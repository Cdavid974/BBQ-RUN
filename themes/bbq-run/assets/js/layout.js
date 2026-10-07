/** Améliore l'accessibilité des panneaux de recherche et du menu mobile. */
(function () {
	'use strict';

	var panels = document.querySelectorAll('.bbq-search, .bbq-mobile-menu');
	if (!panels.length) {
		return;
	}

	// Synchronise l'état annoncé avec l'ouverture native des éléments details.
	panels.forEach(function (panel) {
		var summary = panel.querySelector('summary');
		if (!summary) {
			return;
		}
		var updateExpandedState = function () {
			summary.setAttribute('aria-expanded', panel.open ? 'true' : 'false');
		};
		updateExpandedState();
		panel.addEventListener('toggle', updateExpandedState);
	});

	// Échap ferme le panneau actif et rend le focus à son bouton d'ouverture.
	document.addEventListener('keydown', function (event) {
		if ('Escape' !== event.key) {
			return;
		}

		var openPanels = Array.prototype.filter.call(panels, function (panel) {
			return panel.open;
		});
		var activePanel = openPanels[openPanels.length - 1];
		if (!activePanel) {
			return;
		}

		event.preventDefault();
		activePanel.open = false;
		var trigger = activePanel.querySelector('summary');
		if (trigger) {
			trigger.focus();
		}
	});

	// Ferme le panneau ouvert après un clic extérieur sans déplacer le focus.
	document.addEventListener('click', function (event) {
		panels.forEach(function (panel) {
			if (panel.open && !panel.contains(event.target)) {
				panel.open = false;
			}
		});
	});

	// Referme le menu après le choix d'un lien, utile pour les menus superposés.
	document.querySelectorAll('.bbq-mobile-menu__panel a').forEach(function (link) {
		link.addEventListener('click', function () {
			var menu = link.closest('.bbq-mobile-menu');
			if (menu) {
				menu.open = false;
			}
		});
	});
})();
