/**
 * Vérifie la recherche avant son envoi et annonce une erreur accessible.
 * Le formulaire HTML natif reste utilisable si JavaScript est désactivé.
 */
document.addEventListener('DOMContentLoaded', function () {
	const form = document.querySelector('.bbq-404 .search-form');
	const input = document.querySelector('#bbq-404-search');
	const error = document.querySelector('#bbq-404-search-error');

	if (!form || !input || !error) {
		return;
	}

	// Relie le message à l'entrée pour qu'il soit annoncé avec son champ.
	input.setAttribute('aria-describedby', error.id);

	form.addEventListener('submit', function (event) {
		// trim() empêche l'envoi d'une requête vide ou composée d'espaces.
		const query = input.value.trim();

		if (!query) {
			event.preventDefault();
			input.setAttribute('aria-invalid', 'true');
			error.textContent = 'Saisissez un mot ou une expression avant de lancer la recherche.';
			input.focus();
			return;
		}

		input.value = query;
		input.removeAttribute('aria-invalid');
		error.textContent = '';
	});

	input.addEventListener('input', function () {
		if (input.value.trim()) {
			input.removeAttribute('aria-invalid');
			error.textContent = '';
		}
	});
});
