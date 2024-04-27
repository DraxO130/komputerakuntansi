<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="">
        <label for="">Masukkan gambar:</label>
        <input type="file" id="file" onchange="handleFileSelect(event)">
        <input type="submit" value="Submit">
    </form>    
    <script>
        function handleFileSelect(event) {
            const file = event.target.files[0];
            console.log(file)

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    localStorage.setItem('draftImage', e.target.result);
                    localStorage.setItem('draftImageName', file.name);
                }
                reader.readAsDataURL(file);
            }
        }

        // Check if there's a draft image in localStorage and set it to the file input value
        window.onload = function() {
            const draftImage = localStorage.getItem('draftImage');
            const draftImageName = localStorage.getItem('draftImageName');
            if (draftImage && draftImageName) {
                const fileInput = document.getElementById('file');
                fileInput.value = ''; // Clear the file input
                const file = dataURLtoFile(draftImage, draftImageName); // Convert base64 data to File object
                const fileList = new DataTransfer(); // Create a new DataTransfer object
                fileList.items.add(file); // Add the File object to the DataTransfer object
                fileInput.files = fileList.files; // Set the files property of the file input
            }
        };

        // Function to convert base64 data to File object
        function dataURLtoFile(dataurl, filename) {
            var arr = dataurl.split(','), 
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]), 
                n = bstr.length, 
                u8arr = new Uint8Array(n);
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, {type:mime});
        }
    </script>
</body>
</html>