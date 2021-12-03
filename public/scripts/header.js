var menuitems = document.getElementById('menuitems');
var searchbar = document.getElementById('search-bar');
var searchbtn = document.getElementById('searchbtn');
var closebar  = document.getElementById('close-bar');
menuitems.style.maxHeight = "0px";
searchbar.style.visibility = "hidden";
function menutoggle(){
	if(menuitems.style.maxHeight=="0px"){
		menuitems.style.maxHeight= "220px";
	}else{
		menuitems.style.maxHeight = "0px";
	}
}
function showsearchbar(){
	if(searchbar.style.visibility == "hidden")
		searchbar.style.visibility = "visible";
		searchbar.style.right = "0";

}
function hidesearchbar(){
	searchbar.style.visibility = "hidden";
	searchbar.style.right = "-1500px";
}
