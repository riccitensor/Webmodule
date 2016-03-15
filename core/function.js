function del(id,info,dir,back){
  confirmed = window.confirm(info+" "+id);
  if(confirmed){
    window.location.href=dir+"delete.php?id="+id+"&back="+back;
  }
}

function del_file(file,info,dir){
  if(dir==undefined){dir='';}
  confirmed=window.confirm(info);
  if(confirmed){
    window.location.href=dir+"delete_file.php?file="+file;
  }
}

function del_name(name,info,target,dir){
  if(dir==undefined){dir='';}
  confirmed=window.confirm(info);
  if(confirmed){
    window.location.href=dir+target+"?name="+name;
  }
}


function copy(id,info,dir){
  if (dir==undefined){dir='';}
  confirmed=window.confirm(info+" "+id);
  if (confirmed){
    window.location.href=dir+"copy.php?id="+id;
  }
}

function change_status(id){
  $("#"+id).load("change_status.php?id="+id);
}

function urldecode(str){
  str=str+"";
  str=str.replace("ł","l");
  str=str.replace("Ł","L");
  return encodeURIComponent((str).replace(/\+/g,'%20'));
}

function visible(id) { $("#vis"+id).load("visible.php?id="+id);}

function formSubmit() {  document.getElementById("foremka").submit();}


function loadToId(area,file,page){
    if ((area=='') || (area===undefined)){area='area';}
    if ((file=='') || (file===undefined)){file='list.php';}
    $("#"+area).load(file);
}




function znaczkiWM(){
  $('.lista th span').text("");
  if(order=='desc'){
    $('#'+column).text("▼");
  }
  else{
    $('#'+column).text("▲");
  }
}

function targetBlank(url){
  blankWin=window.open("http://"+url,'_blank','menubar=yes,toolbar=yes,location=yes,directories=yes,fullscreen=no,titlebar=yes,hotkeys=yes,status=yes,scrollbars=yes,resizable=yes');
}

function url_click(url){
  okienko=window.open(url,'_self','menubar=yes,toolbar=yes,location=yes,directories=yes,fullscreen=no,titlebar=yes,hotkeys=yes,status=yes,scrollbars=yes,resizable=yes');
}

function redirect(czas,url){
    czas=czas-1;
    if (czas<=0) {
        url_click(url);
    } else {
        setTimeout("redirect("+czas+",'"+url+"')",1000);
    }
}

//-------------------- OPERATIONS ----------------------------------------------

function op_lista(page){$("#area").load("index.php?operation=lista&column="+column+"&order="+order+"&page="+page+"&search="+urldecode($("#search").val()));}

function op_del(id,info,dir,back){
  confirmed = window.confirm(info+" "+id);
  if(confirmed){
    window.location.href=dir+"index.php?operation=delete&id="+id+"&back="+back;
  }
}

function op_del_file(file,info,dir){
  if(dir==undefined){dir='';}
  confirmed=window.confirm(info);
  if(confirmed){
    window.location.href=dir+"index.php?operation=delete_file&file="+file;
  }
}

function op_del_name(name,info,target,dir){
  if(dir==undefined){dir='';}
  confirmed=window.confirm(info);
  if(confirmed){
    window.location.href=dir+target+name;
  }
}

function op_params(path,info){
  confirmed=window.confirm(info);
  if(confirmed){
    window.location.href=path;
  }
}

function op_copy(id,info,dir){
  if (dir==undefined){dir='';}
  confirmed=window.confirm(info+" "+id);
  if (confirmed){
    window.location.href=dir+"index.php?operation=copy&id="+id;
  }
}

function op_visible(id) { $("#vis"+id).load("index.php?operation=visible&id="+id);}

function op_sortcol(column){
  if(column==window.column){
    if(window.order=='asc'){window.order='desc';}else{window.order='asc';}
  }else{
     window.column=column; window.order='asc';
  }
  op_lista(1);
}

//depricated
function ajaxloadpage(page){$("#area").load("list.php?column="+column+"&order="+order+"&page="+page+"&search="+urldecode($("#search").val()));}


function popup(id){
    window.open("/engine/modules/popup/popup_news.php?id="+id,"","width=800,height=350");
}