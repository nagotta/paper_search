document.addEventListener('DOMContentLoaded', () => {
    const dropArea = document.getElementById('dropArea');
    const fileList = document.getElementById('fileList');
    const uploadButton = document.getElementById('uploadButton');
    let uploadedFiles = [];

    dropArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropArea.classList.add('dragover');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('dragover');
    });

    dropArea.addEventListener('drop', (event) => {
        event.preventDefault();
        dropArea.classList.remove('dragover');

        const files = event.dataTransfer.files;

        for (const file of files) {
            uploadedFiles.push(file);
            renderFileItem(file);
        }
    });

    function renderFileItem(file) {
        const listItem = document.createElement('li');
        listItem.className = 'fileItem';
        listItem.textContent = file.webkitRelativePath || file.name;

        const deleteButton = document.createElement('span');
        deleteButton.className = 'deleteButton';
        deleteButton.textContent = 'Delete';
        deleteButton.addEventListener('click', () => {
            deleteFile(file);
            listItem.remove();
        });

        listItem.appendChild(deleteButton);
        fileList.appendChild(listItem);
    }

    function deleteFile(file) {
        const index = uploadedFiles.indexOf(file);
        if (index !== -1) {
            uploadedFiles.splice(index, 1);
        }
    }

    uploadButton.addEventListener('click', () => {
        console.log('Uploaded files:', uploadedFiles);
        uploadFilesToServer(uploadedFiles);
    });

    function uploadFilesToServer(files) {
        const formData = new FormData();

        for (const file of files) {
            formData.append('files[]', file);
        }

        fetch('upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Network response was not ok.');
        })
        .then(data => {
            console.log('Server response:', data);
            // アップロードが成功した場合の処理を記述
        })
        .catch(error => {
            console.error('There was a problem with your fetch operation:', error);
            // アップロードが失敗した場合の処理を記述
        });
    }
});


