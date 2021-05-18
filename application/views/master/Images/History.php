<!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="<?= assets() ?>plugins/wowo_animated/animate.css">
    <script src="<?= assets() ?>plugins/wowo_animated/wow.min.js"></script>
    <script>new WOW().init();</script>
<!-- end plugin -->
<style type="text/css">
  .boxImages{
    display: flex;
    transition: 0.4s;
  }
  .mouseActive{
    border-style:  dotted;
    border-width: 1px,
    border-color:#1daee9;
    padding: 20px;
    border-radius: 20px;
  }
  .selectActive{
    border-style:  solid;
    border-width: 1px,
    border-color:#00a65a;
  }
</style>
<div class="post">
    <div class="user-block">
          <span class="username">
            <a href="#" class="UploadButton">
              <i class="fa fa-upload"></i>
            Upload Gambar Baru</a>
          </span>
      <span class="description">Upload gambar dari Drive agar ditambahkan kedalam galeri</span>
    </div>
    <div class="row margin-bottom">
        <div class="col-sm-2">
          <table ><tr><td  align="center" valign="midle">
            <button type="submit" id="selectButton" onclick="DeleteImages()" style="border-radius: 50px" class="btn btn-default selectButton disabled" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="fa fa-trash"></i> </button>
          </td></tr></table>
        </div>
        <div class="col-sm-8">
          <div id="ListingGalery"></div>
              <div class="box-footer text-center">
                <table width="100%">
                  <tr>
                      <td>
                        <button type="button" id="downTombol" class="btn btn-block btn-default ">
                          <i class="fa fa-sort-down"></i>
                        </button>
                      </td>
                      <td>
                        <button type="button" id="upTombol" class="btn btn-block btn-default Upbt">
                          <i class="fa fa-sort-up"></i>
                        </button>
                      </td>
                      <td width="40"></td>
                      <td >
                        <button    type="button" id="showAllTombol" class="btn btn-block btn-default ShowAll">
                          <i class="glyphicon glyphicon-th"></i>
                        </button>
                      </td>
                  </tr> 
                  <tr >
                    <td colspan="4">
                      <br>
                      <button type="submit" id="selectButton" onclick="ChoseImages()" class="btn btn-success store_data selectButton disabled" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="<?= $submitIcon ?>"></i> <?= $submitLabel ?></button>
                      <button type="submit" id="selectButton" onclick="DeleteImages()"  class="btn btn-default selectButton disabled" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="fa fa-trash"></i> Hapus</button>
                    </td>
                  </tr>
                </table>  
            </div>
        </div>  
    </div>
</div>
<script type="text/javascript">

  //Select data from Images
function ChoseImages() {
  Gsatuan[<?= $key ?>][2]=uriSelected;
  CloseModalAndrefresh();
}

function DeleteImages() {
  //Ajax Delete disini
              $.ajax({
            url: "<?= site_url('delete') ?>",
            data:"&filedes="+uriSelected,
            type: "post",
            dataType: "json",
            cache: false,
            success: function(json) {
              console.log(json.status)
              if (json.status) {
                GetImagesFromDir(1);
              }else{
                alert("Gagal Hapus Gambar")
              }
            }
        });
  //Refresh Gambar----            
}
//Actions on Event try do something
function ImagesActiveMouse(e) {
  $(e).addClass('mouseActive');
}
function ImagesMouseOver(e) {
  $(e).removeClass('mouseActive');
}
function selectActive(e,v) {
  if ($(e).hasClass("selectActive")) {
    $(e).removeClass('selectActive');
        uriSelected=v;
        $('.selectButton').addClass('disabled');
  }else{
    $(e).addClass('selectActive');
          uriSelected=v;
          $('.selectButton').removeClass('disabled');
  }
}

function selectShutdown(e) {
  $('.selectButton').addClass('disabled');
  $(e).removeClass('selectActive');
}

//Show Images Funtions// if 1=(animations true) // if 0=(animations false) 
GetImagesFromDir(1);
//----end funtions
//how to set range and length the images show in several Functions with event button
$('#downTombol').click(function(event) {
  StartIndex+=3;
  GetImagesFromDir(1);
});
$('#upTombol').click(function(event) {
  StartIndex-=3;
  GetImagesFromDir(1);
});
$('#showAllTombol').click(function(event) {
  lengthShow=ImagesData.length;
  GetImagesFromDir(0);
});
// ----and--set


//Scan Image from Assets Directory
function GetImagesFromDir(e){
  console.log("Lihat Value: "+e);
  console.log(e);
    var folder = "<?= assets() ?>images/Galery/";
      $.ajax({
        url : folder,
        success: function (data) {
          //masih ada bug pada find meskipun udah jalan,
          $(data).find("a").attr("href", function (i, val) {
              if( val.match(/\.(jpe?g|png|gif)$/) ) { 
                  if (!data.indexOf(val) >= 0) {
                  ImagesData.unshift(val);
                  }
                  if (e==1) {
                  ImageListing(); 
                  }else{
                    ImageListingClear();
                  }
              } 
          });
        }
      });
          
    }
//Append Images to documents From Array List
function ImageListingClear() {
  var results = "";
  results = `<div class="row">`;
  let x=StartIndex;
  for (var i=0; i<lengthShow; i=i+2) { 
    results +=`<div class="col-sm-6">
                  <br>
                      <a href="#" onclick="selectActive(this,'${ImagesData[x]}')" onfocusout="selectShutdown(this)" ondblclick="ChoseImages()" onmouseenter="ImagesActiveMouse(this)" onmouseout="ImagesMouseOver(this)" class="boxImages">
                        <img class="img-responsive " src="${folderImagesAssets+ImagesData[x]}" alt="Photo">
                      </a>
                  <br>`;
    x+=1;
    if(i+1 < ImagesData.length){
      results += `    <a href="#" onclick="selectActive(this,'${ImagesData[x]}')" onfocusout="selectShutdown(this)" ondblclick="ChoseImages()" onmouseenter="ImagesActiveMouse(this)" onmouseout="ImagesMouseOver(this)" class="boxImages">
                        <img class="img-responsive " src="${folderImagesAssets+ImagesData[x]}" alt="Photo">
                      </a>
              </div>`;x+=1;
    } else{results += "</div>";}
  }
  results += `
              </div>`;
    var div = document.getElementById("ListingGalery");
    div.innerHTML = results; 
}




function ImageListing() {
  var results = "";
  results = `  <div class="row">`;
  let x=StartIndex;
  for (var i=0; i<lengthShow; i=i+2) { 
    results +=`<div class="col-sm-6">
                  <br>
                    <div class="span3 wow flipInX center">
                      <a href="#" onclick="selectActive(this,'${ImagesData[x]}')" ondblclick="ChoseImages()" onfocusout="selectShutdown(this)" onmouseenter="ImagesActiveMouse(this)" onmouseout="ImagesMouseOver(this)" class="boxImages">
                        <img class="img-responsive " src="${folderImagesAssets+ImagesData[x]}" alt="Photo">
                      </a>
                    </div>
                  <br>`;
    x+=1;
    if(i+1 < ImagesData.length){
      results += `
                  <div class="span3 wow flipInX center">
                    <a href="#" onclick="selectActive(this,'${ImagesData[x]}')" ondblclick="ChoseImages()" onfocusout="selectShutdown(this)" onmouseenter="ImagesActiveMouse(this)" onmouseout="ImagesMouseOver(this)" class="boxImages">
                      <img class="img-responsive" src="${folderImagesAssets+ImagesData[x]}" alt="Photo">
                      </a>
                  </div>
              </div>`;x+=1;
    } else{results += "</div>";}
  }
  results += `
              </div>`;
    var div = document.getElementById("ListingGalery");
    div.innerHTML = results;    
}

//funtions untuk menghitung jumlah JSON data dalam sebuah state
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

  $(document).ready(function() {
      //Functions untuk menampilakn Halaman Upload Gambar
      $('.UploadButton').click(function(event) {
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