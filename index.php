<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //if the file is uploaded with any errors encounterd
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        //setting the allowed file format
        $allowed = array("pdf" => "application/pdf");
        //getting the files name,size and type using the $_FILES //superglobal
        $filename = $_FILES['pdf']['name'];
        $filesize = $_FILES['pdf']['size'];
        $filetype = $_FILES['pdf']['type'];
        //verifying the extention of the file
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) die("Error: the file format is not acceptable");
        //verifying the file size
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) die("Error: file size too large!!");
        if (in_array($filetype, $allowed)) {
            if (file_exists("temp/" . $filename)) {
                die("Sorry the file already exists");
            } else {
                move_uploaded_file($_FILES['pdf']['tmp_name'], "temp/" . $filename);
                echo "File was uploaded successfully <br>";
            }
        } else {
            echo "Sorry a problem was encountered when trying to upload data!!";
        }
    } else {
        echo "Error: " . $_FILES['pdf']['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mergi.fy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Ubuntu&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.2/Sortable.min.js">

    </script>
    <link rel="stylesheet" href="index.css"></script>
    <script src="index.js"></script>
</head>

<body>

    <div class="nav">
        <p class="navico">Mergi.fy</p>
        <div class="opts">
            <a href="" class="optin">Merge PDF</a>
            <a href="" class="optin disabled">Comming Soon</a>
            <a href="" class="optin disabled">Comming Soon</a>
            <a disabled href="" class="optin disabled">Comming Soon</a>
        </div>
    </div>
    <div class="upbox">
        <div class="launch">
            <div class="prev" id="prev" hidden>
                <div class="uptext pre2">YOU CAN EDIT YOUR PDF(s) LATER</div>
                <p id="files-area">
                    <span id="filesList">
                        <span id="files-names"></span>
                    </span>
                </p>
            </div>

            <div class="uptext" id='uptext'>UPLOAD AND&nbsp;<span class="txt">MERGE</span></div>
            <div class="buttons">

                <label class="but" id="lab" for="attachment">SELECT FILES</label>
                <form action="#" method="POST" id="upload" enctype="multipart/form-data">
                    <input type="file" class='but' name="file[]" accept=".pdf" id="attachment" style="visibility: hidden; position: absolute;" multiple />&nbsp;
                </form>
                <input type="Button" class='but disabled' id="next" onclick="step2()" value="Next Step"></input>
            </div>
        </div>
    </div>



    <section id='step2' class="step2">
        <div class="uptext pre2">Drag the files to change the sequence</div>
        <div class="step2_div">
            <div class="wrapper" id="list">
            </div>
            <p id="err" class="err" hidden></p>
            <script>
                const dragArea = document.querySelector(".wrapper");
                new Sortable(dragArea, {
                    animation: 350
                });
            </script>
            <input type="Button" class='but small' id="next" onclick="up()" value="Upload"></input>
        </div>
    </section>
    <script src="https://kit.fontawesome.com/3da1a747b2.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>
        $("#attachment").on('change', function(e) {
            document.getElementById('uptext').hidden = true;
            var divhold = document.getElementById('tab')
            document.getElementById('prev').hidden = false;
            document.getElementById('next').disabled = false;
            $("#next").removeClass("disabled");
            for (var i = 0; i < this.files.length; i++) {
                let fileBloc = $('<span/>', {
                        class: 'file-block'
                    }),
                    fileName = $('<span/>', {
                        class: 'name',
                        text: this.files.item(i).name
                    });
                fileBloc.append('<span class="file-delete"><span style="font-size:14px" class="fa">&#xf057;</span></span>')
                    .append(fileName);
                $("#filesList > #files-names").append(fileBloc);
            };
            for (let file of this.files) {
                dt.items.add(file);
            }
            this.files = dt.files;

            $('span.file-delete').click(function() {
                let name = $(this).next('span.name').text();
                $(this).parent().remove();
                for (let i = 0; i < dt.items.length; i++) {
                    if (name === dt.items[i].getAsFile().name) {
                        dt.items.remove(i);
                        continue;
                    }
                }
                document.getElementById('attachment').files = dt.files;
            });
        });
    </script>
</body>

</html>