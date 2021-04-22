
<div class="post">
                  <div class="user-block">
                        <span class="username">
                          <a href="#" class="UploadButton">
                            <i class="fa fa-upload"></i>
                          Upload Gambar Baru</a>
                        </span>
                    <span class="description">Upload gambar dari Drive agar ditambahkan kedalam galeri</span>
                  </div>
                  <!-- /.user-block -->
                  <div class="row margin-bottom">
                    <div class="col-sm-6">
                      <img class="img-responsive" src="https://adminlte.io/themes/AdminLTE/dist/img/photo1.png" alt="Photo">

                    </div>
                    <!-- /.col -->
                  <div id="UjiCoba"></div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
<script type="text/javascript">
 $(document).ready(function() {
  //Global variabel state
    let ImagesData=[];
    let DataMatrix=[];
        let historyData = null;
GetImagesFromDir();
function GetImagesFromDir(){
        var folder = "<?= assets() ?>images/Galery/";
          $.ajax({
              url : folder,
              success: function (data) {
                // console.log(data)
                  $(data).find("a").attr("href", function (i, val) {
                      if( val.match(/\.(jpe?g|png|gif)$/) ) { 
                          ImagesData.unshift(folder+val);
                          ImageListing();
                      } 
                  });
              }
          });
          
    }
  function ImageListing() {
        var results = "";

          results = `<div class="col-sm-6">
                      <div class="row">`;
                      let x=0;
            for (var i=0; i<ImagesData.length; i=i+2) { 
                results +=`<div class="col-sm-6">
                            <br>
                            <img class="img-responsive" src="${ImagesData[x]}" alt="Photo">
                            <br>`;
                            x+=1;
                if(i+1 < ImagesData.length){
                          results += `<img class="img-responsive" src="${ImagesData[x]}" alt="Photo">
                          </div>`;  
                          x+=1;
                } else{
                             results += "</div>";   
                }
            }

        // results += "<tr><td colspan=2><a href='#' onclick='javascript:RedirectParentToDownload();'>View all content ></a></td></tr>";
        results += "</div></div>";
         var div = document.getElementById("UjiCoba");
        div.innerHTML = results;    
    }//funtions untuk menghitung jumlah JSON data dalam sebuah state
  function count(obj) {
     var count=0;
     for(var prop in obj) {
        if (obj.hasOwnProperty(prop)) {
           ++count;
        }
     }
     return count;
  }
        //end---
      $('.UploadButton').click(function(event) {
        // alert("Upload");
            $.ajax({
            url: "<?= site_url('browse') ?>",
            type: "GET",
            success: function(resp) {
                $("#tampil_uploadfile").html(resp);
                $("#modal_browse").modal('show');
            }
        });

      });

    });
</script>