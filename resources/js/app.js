import './bootstrap';

window.addEventListener('load', function() {
	// Animação do menu de vir de cima para baixo
	let item = document.querySelectorAll('.item');
	item.forEach((element) => {
		element.classList.remove('opacity-0', '-translate-y-5');
		element.classList.add('opacity-100', 'translate-y-0');
    });
	
	// Animação dos conteúdos da página de vir de baixo para cima
	// O IntersectionObserver verifica se o card já foi ou não renderizado para apenas fazer a animação quando ele aparecer na tela
	let observer = new IntersectionObserver((entries) => {
		entries.forEach(element => {
			if (element.isIntersecting) {
				element.target.classList.remove('opacity-0', 'translate-y-10');
				element.target.classList.add('opacity-100', 'translate-y-0');
				// O unobserve faz com que o elemento que fez a animação não tenha que fazer de novo a animação quando desaparecer da tela, só basta fazer a animação na primeira vez
				observer.unobserve(element.target);
			}
		});
	});
	let card = document.querySelectorAll('.card');
	card.forEach(element => {
		observer.observe(element);
	});
	
	// Pop-Up de mostras as imagens aumentadas
	let increaseButton = document.querySelectorAll('.increase-button');
	let closeButton = document.querySelectorAll('.close-button');
	let imageFull = document.querySelectorAll('.image-full');
	let image = document.querySelectorAll('.image');
	increaseButton.forEach((element, i) => {
		element.addEventListener('click', function() {
			imageFull[i].classList.remove('hidden');
			document.body.classList.add('overflow-hidden');
		});
		closeButton[i].addEventListener("click", function(e) {
			imageFull[i].classList.add("hidden");
			document.body.classList.remove("overflow-hidden");
		});
	});
	
	// Opções de Perfil, com o efeito de passar o mouse
	let iconProfile = document.querySelector('.icon-profile');
	if(iconProfile) {
		let menuProfile = document.querySelector('.menu-profile');
		iconProfile.addEventListener('mouseenter', function() {
			menuProfile.classList.remove('hidden');
		});
		menuProfile.addEventListener('mouseenter', function() {
			menuProfile.classList.remove('hidden');
		});
		iconProfile.addEventListener('mouseleave', function() {
			menuProfile.classList.add('hidden');
		});
		menuProfile.addEventListener('mouseleave', function() {
			menuProfile.classList.add('hidden');
		});
	}
	
	// Opções de editar e eliminar o post e comentário, embora seja utilizado no comentário, acabei por não retirar depois da reutilização, mas serve para qualquer item com submenu de definições
	let settingsPostButton = document.querySelectorAll('.settings-post-button');
	let settingsPost = document.querySelectorAll('.settings-post');
	settingsPostButton.forEach((element, i) => {
		element.addEventListener('click', function() {
			settingsPost[i].classList.toggle('hidden');
		});
	});
});