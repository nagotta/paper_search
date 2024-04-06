#!/bin/bash

# Login Information(unsecure)
username=admin
password=superSecure
baseurl=http://localhost:8081
auth_token=d28ca6c8-9dda-47b8-94a3-3d98c6abf63e

# metadata(extracted from PDF)
title=
#etc1
#etc2
#...
language=jpn


# PUT Document
response=$(curl -i -X PUT -H "Cookie: auth_token=${auth_token}" -d "title=${title}&language=${language}" "${baseurl}/api/document")

# Check HTTP_status_code
http_status=$(echo "$response" | grep -i "HTTP/" | awk '{print $2}')

# if http_status is not 200 -> retry once
if [ "$http_status" -ne 200 ]; then
	auth_token=$(./get_auth_token.sh)
	response=$(curl -i -X PUT -H "Cookie: auth_token=${auth_token}" -d "title=${title}&language=${language}" "${baseurl}/api/document")
	# Check HTTP_status_code
	http_status=$(echo "$response" | grep -i "HTTP/" | awk '{print $2}')
	if [ "$http_status" -ne 200 ]; then
		echo "Error : Couldn't PUT Document. HTTP status code is ${http_status}"
		exit 1
	fi
fi

# Extracting DocumentID
document_id=$(echo "$response" | grep -o '"id":"[^"]*' | sed 's/"id":"//')

# PUT File to a Document(only file, not directory)
response=$(curl -i -X PUT -H "Cookie: auth_token=${auth_token}" -F "id=${document_id}" -F "file=@$1")

# Check HTTP_status_code
http_status=$(echo "$response" | grep -i "HTTP/" | awk '{print $2}')
if [ "$http_status" -ne 200 ]; then
	echo "Error : Couldn't PUT $1 to a ${document_id}"
fi
# Directory will be run recursively.

