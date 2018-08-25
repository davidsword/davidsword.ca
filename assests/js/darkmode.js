/* eslint-disable */
var contrastBtn = document.querySelector('.icon_darkmode');
var bodyEle = document.querySelector('body');
if (localStorage.getItem('darkmode') === 'yes') {
	bodyEle.classList.add("darkmode");
}

function darkmodetoggle(e) {
	e.preventDefault();
	var darkmode = localStorage.getItem('darkmode');
	if (darkmode === "yes") {
		bodyEle.classList.remove("darkmode");
		localStorage.setItem('darkmode', 'no');
	} else {
		bodyEle.classList.add("darkmode");
		localStorage.setItem('darkmode', 'yes');
	}
	return;
}

contrastBtn.addEventListener('click', darkmodetoggle);

var extraLinks = document.querySelectorAll('.link_darkmode');
for (var i = 0; i != extraLinks.length; i += 1) {
	extraLinks[i].addEventListener('click', darkmodetoggle);
}
