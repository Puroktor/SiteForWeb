let length = Math.random()*15+25;;
let clicked = [];
let cubes = [];
let speeds = [];
let y= [];
let w = 90;
let h = 90;

function getWidth(){
	return Math.min(window.innerWidth, document.documentElement.clientWidth);
}
function getHeight(){
	return Math.min(window.innerHeight, document.documentElement.clientHeight)-10;
}
function getRandomColor(){
	let letters = '0123456789ABCDEF';
	let col = '#';
	for(let i=0; i<6;i++){
		col+=letters[Math.floor(Math.random()*16)];
	}
	return col;
}
function start(){
	for(let i=0;i<length;i++){
		cubes[i] = document.createElement('div');
		cubes[i].style.position='absolute';
		cubes[i].innerHTML= `<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" style="enable-background:new 0 0 512 512; fill: ${getRandomColor()}; stroke: black; stroke-width: 1"><path d="M509.534,169.72c-8.653-23.195-35.356-42.812-79.363-58.305c-20.38-7.175-39.633-11.785-50.482-14.112c-10.031-21.838-25.6-40.566-45.457-54.535C311.245,26.596,284.193,18.049,256,18.049c-28.194,0-55.247,8.547-78.233,24.719c-19.857,13.97-35.426,32.697-45.457,54.537c-10.849,2.326-30.102,6.936-50.481,14.111c-44.008,15.493-70.71,35.11-79.363,58.305c-3.294,8.831-4.928,22.66,5.997,38.396c19.478,28.056,69.65,46.342,97.824,54.744c46.87,13.98,100.041,21.678,149.715,21.678s102.845-7.698,149.715-21.678c28.173-8.403,78.346-26.687,97.824-54.744C514.463,192.381,512.83,178.552,509.534,169.72z M256,51.439c39.521,0,75.712,23.104,92.653,58.312c-8.807,9.164-33.92,27.725-92.653,27.725c-41.329,0-65.639-9.225-78.755-16.965c-6.649-3.923-11.083-7.794-13.898-10.761C180.287,74.541,216.479,51.439,256,51.439z M476.112,189.076c-11.587,16.689-48.891,32.53-79.94,41.79c-43.224,12.89-94.314,20.285-140.173,20.285c-99.692,0-200.183-33.368-220.112-62.073c-3.256-4.692-2.474-6.789-2.14-7.684c4.797-12.857,26.222-26.833,58.78-38.345c17.386-6.147,34.238-10.315,44.523-12.593c4.309,4.924,10.649,10.846,19.72,16.656c24.605,15.762,57.99,23.754,99.228,23.754s74.623-7.992,99.228-23.755c9.072-5.811,15.411-11.733,19.72-16.656c10.287,2.278,27.137,6.446,44.523,12.593c32.559,11.512,53.985,25.489,58.781,38.345C478.587,182.287,479.369,184.383,476.112,189.076z"/><circle cx="129.146" cy="186.532" r="16.262" /><circle cx="382.853" cy="186.532" r="16.262" /><circle cx="256" cy="212.553" r="16.262" /><rect x="239.305" y="329.179" width="33.388" height="108.045" /><rect x="322.966" y="329.179" width="33.388" height="164.772" /><rect x="155.645" y="329.179" width="33.388" height="164.772" /></svg>`;
		//cubes[i].style.backgroundColor = getRandomColor();
		cubes[i].style.width= w +'px';
		cubes[i].style.height= h +'px';
		cubes[i].style.left = Math.random() * (getWidth()-w);
		cubes[i].style.top = Math.random() * (getHeight()-h);
		y[i]= Math.random()>0.5 ? parseInt(cubes[i].style.top) : -1 * parseInt(cubes[i].style.top);
		speeds[i]= Math.random()*7+1;
		
		document.body.appendChild(cubes[i]);
		
		cubes[i].onmousedown = function(event) {
			clicked[i] = true;
			
			let shiftX = event.clientX - cubes[i].getBoundingClientRect().left;
			let shiftY = event.clientY - cubes[i].getBoundingClientRect().top;

			function moveAt(pageX, pageY) {
				cubes[i].style.left = pageX - shiftX;
				cubes[i].style.top = pageY - shiftY;
			}
			
			moveAt(event.pageX, event.pageY);
			
			function onMouseMove(event) {
				if(event.pageX-shiftX<= 0 || event.pageX-shiftX>= getWidth()-w ||event.pageY-shiftY<=0 || event.pageY-shiftY>=getHeight()-h){
					onMouseUp();
				}else{
					moveAt(event.pageX, event.pageY);
				}
			}

			document.addEventListener('mousemove', onMouseMove);
			
			function onMouseUp() {
				document.removeEventListener('mousemove', onMouseMove);
				cubes[i].onmouseup = null;
				y[i] = parseInt(cubes[i].style.top);
				clicked[i] = false;
			}
			
			cubes[i].onmouseup = onMouseUp;
		};

		cubes[i].ondragstart = function() {
			return false;
		};
	}

	window.requestAnimationFrame(step);
}

function step(){
	for(let i=0;i<length;i++){
		if(!clicked[i]){
			cubes[i].style.top = Math.abs(y[i]);
			if(Math.abs(y[i])+h>= getHeight() && y[i]>0){
				y[i]*=-1;
			    cubes[i].firstChild.style.fill = getRandomColor();
		    }
		    else if(y[i]<=0 && y[i]+speeds[i]>=0){
			    cubes[i].firstChild.style.fill = getRandomColor();
		    }
			y[i]+=speeds[i];
		}
	}
	window.requestAnimationFrame(step);
}