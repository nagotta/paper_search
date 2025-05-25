#!/bin/bash

# Login Information(unsecure)
username=admin
password=superSecure
baseurl=http://localhost:8081
auth_token=d28ca6c8-9dda-47b8-94a3-3d98c6abf63e



# HTTPrequest
response=$(curl -i -X POST -d username=${username} -d password=${password} "${baseurl}/api/user/login" 2>/dev/null)

if [ "$?" -eq 0 ]; then
    # Get HTTP_status_code
    http_status=$(echo "$response" | head -n 1 | cut -d' ' -f2)
else
    # echo "Request failed"
    exit 1
fi

# if HTTP_status_code is 200 -> get auth_token
if [ "$http_status" -eq 200 ]; then
    auth_token=$(echo "$response" | grep -i "^Set-Cookie:" | cut -d'=' -f2 | cut -d';' -f1)
    echo "$auth_token"
else
    # echo "Request failed with status code: $http_status"
    exit 1
fi




