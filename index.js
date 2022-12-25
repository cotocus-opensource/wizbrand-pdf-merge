var count = 0;
        const dt = new DataTransfer()

        function selected(up) {
            let files = up.files;
            if (files.length != 0) {



            }

            for (file of files) {
                console.log(file)
                if (count <= 3) {
                    divhold.innerHTML += `
                        <td>${file.name}</td>
                        `
                } else {
                    document.getElementById('lab').innerHTML = "Maximum 4 files"
                    document.getElementById('lab').classList = "but disabled "
                    removeFile(count);
                }
                count++
            }
        }


        function removeFile(name) {
            var files = document.getElementById('upload').files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i]
                if (name !== file.name)
                    dt.items.add(file)
            }

            files = dt.files 
        }

        function step2() {
            document.getElementById("step2").scrollIntoView({
                behavior: 'smooth'
            });
            var files = dt.files;
            ls = document.getElementById('list');

            for (let i = 0; i < files.length; i++) {

                ls.innerHTML += `
                    <div class="item">
                    <span class="text" id="${i}">${files[i].name}</span>
                    </div>  
                    </div>
                    `
            }
        }

        function up() {
            let divs = (document.querySelectorAll(".text"));
            var formdata = new FormData();
            for (let index = 0; index < divs.length; index++) {
                filseq = divs[index].id
                formdata.append('files[]', jQuery('#attachment').get(0).files[filseq]);
            }
            $.ajax({
                url: '/upload.php',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                error: function(request, error) {
                    console.log(arguments);
                    document.getElementById('err').hidden = false;
                    document.getElementById('err').innerHTML = "ERROR Server Responded with:" + error;
                },
                success: function(data) {
                    console.log(data.success);
                    if (!data || data.success==false) {
                        console.log(arguments);
                        document.getElementById('err').hidden = false;
                        document.getElementById('err').innerHTML = "Error: "+data.error;

                    }
                    else{

                        document.getElementById('err').hidden = true;
                        var link = document.createElement("a");
                        link.setAttribute('download', "Mergify_Merged.pdf");
                        link.href = data;
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    }
                }
                    
            });
        }