
function get_current_shade() {
	let shade;

	shade = localStorage.getItem('shade');

	// ok new visitor then, check the OS and note the inherited value
	if ( ! shade)
		shade = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light'

	return shade;
}

function shade_init() {
	const shade = get_current_shade();
	document.documentElement.classList.add(shade+"mode")
	console.log("shade init: "+shade+"mode");
}

function shade_toggle() {

	// remove current
	const shade = get_current_shade();
	document.documentElement.classList.remove(shade+"mode")

	// add new
	const newshade = shade == 'dark' ? 'light' : 'dark';
	document.documentElement.classList.add(newshade+"mode")

	// stash
	localStorage.setItem('shade', newshade);
}
