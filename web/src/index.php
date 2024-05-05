<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload and Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="dropArea">Drop files or directories here</div>
    <ul id="fileList"></ul>
    <button id="uploadButton">Upload</button>

    <!-- Add input fields for editing -->
    <form id="editForm" style="display:none;">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="reference">Reference:</label><br>
        <textarea id="reference" name="reference"></textarea><br>
        <input type="submit" value="Submit" id="submitButton">
    </form>

    <script src="script.js"></script>
</body>
</html>
