function displayleft(obj,name)
{
 LeftDiv=eval("document.all."+name)
   if (LeftDiv.style.display=="none"){
     LeftDiv.style.display="";
     obj.src="images/t_left.gif"
     obj.title="���������Ϣ��"
     document.getElementById("rightbox").style.left='176px'
   }
   else{
     LeftDiv.style.display="none";
     obj.src="images/t_right.gif"
     obj.title="��ʾ�����Ϣ��"
     document.getElementById("rightbox").style.left='8px'
   }
 }
function displayup(obj,name)
{
 LeftDiv=eval("document.all."+name)
   if (LeftDiv.style.display=="none")
   {
     LeftDiv.style.display="";
     obj.src="images/arrow_up.gif"
     obj.title="���ض�����Ϣ��"
	 
      }
     else
    {
     LeftDiv.style.display="none";
     obj.src="images/arrow_down.gif"
     obj.title="��ʾ������Ϣ��"
    }
 }
