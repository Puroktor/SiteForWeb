function onLoad(){
    let themeCount = document.body.getAttribute("data-themecount");
	if(!getCookie("agreed")){
		setTimeout(()=>{
			if(confirm("Вы согласны на использование cookie?\nФорум без них работать не будет!")){
				setCookie("agreed", "true", {'max-age': 3600*24*30});
			}
			else{
			    window.location.href = "/";
			}
		},500);
	}
	else{
	    for(let i =1;i<=themeCount;i++){
    		if(getCookie("open"+i)){
    			open_theme(i);
    		}
	    }
	}
}
function open_theme(id){
	let el = document.getElementById("theme"+id);
	let plus = document.getElementById("plus"+id);
	if(el.style.display == "none"){
		el.style.display="block";
		plus.innerHTML = "−";
		setCookie("open"+id, "true", {'max-age': 3600*24});
	}
	else{
		el.style.display="none";
		plus.innerHTML = "+";
		deleteCookie("open"+id);
	}
}
function mesChanged(input){
    let p = input.parentElement.getElementsByClassName("dig")[0];
    console.log(input.value.length);
    p.innerHTML=input.value.length;
}