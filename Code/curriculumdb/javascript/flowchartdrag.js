/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    var isDragging = false;
    var objSource = "";
    var row = 0;
    var row1 = 0;
    var test = 0;
    
    function Box (id, dropState) {
      this.id = id;
      this.canDrop = dropState;
      this.value="empty";
    }


    var arrBox = new Array();


    function allowDrop(obj, ev)
    {
        if (arrBox[obj.id].canDrop) {
                    ev.preventDefault(); //allow drop
        }
    }

    function drag(parent, ev)
    {
        ev.dataTransfer.setData("Text",parent.id + ":" + ev.target.id);
    }

    function drop(dropTarget, ev)
    {
        if (arrBox[dropTarget.id].canDrop) {
            ev.preventDefault(); //do not try to open link
            var dragData=ev.dataTransfer.getData("Text");
                        var indexColon = dragData.indexOf(":");
                        var parentId = dragData.substring(0,indexColon);
                        var dragId = dragData.substring(indexColon+1);
                        //alert(dropTarget.id + ":" + parentId);
            ev.target.appendChild(document.getElementById(dragId));
                        var dragv = document.getElementById(dragId);
                        arrBox[dropTarget.id].canDrop = false;
                        arrBox[dropTarget.id].value = dragId;
                        arrBox[parentId].value = "";
                        var newP = dropTarget.id;
                        var temp = dragv.getElementsByTagName("input")[0].value;
                        var index1 = temp.indexOf(';');
                        var index = temp.indexOf(':');
                        var cid = temp.substring(index+1);
                        var fid = temp.substring(0,index1);
                        dragv.getElementsByTagName("input")[0].value = fid + ";" + newP + ":" + cid;
            }
    }

    function dragStart(obj) {
        isDragging = true;
        objSource = obj;
        objSource.style.border = 'thin solid black';
    }

    function dragEnd(obj) {
        if (isDragging) {
                    objSource.style.border = 'thin solid red';
                    arrBox[objSource.id].canDrop = true;
            }
            isDragging = false;
    }