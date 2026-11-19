/* Dave Procode — animations légères (aucune dépendance). */
(function () {
	'use strict';
	var doc = document.documentElement;
	doc.classList.add('dp-js');
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function ready(fn) {
		if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); }
	}

	ready(function () {
		// Apparition au défilement.
		var targets = document.querySelectorAll(
			'.dp-page .dp-head, .dp-page .dp-card, .dp-page .dp-tile, .dp-page .dp-sector, .dp-page .dp-tl-step,' +
			'.dp-page .dp-offer, .dp-page .dp-tech-card, .dp-page .dp-photo, .dp-page .dp-stage, .dp-page .dp-cta,' +
			'.dp-page .dp-split > .wp-block-column, .dp-page .wp-block-latest-posts li, .dp-page .dp-course,' +
			'.dp-page .dp-pf-card, .dp-page .dp-contact-card, .dp-page .dp-banner, .dp-page .dp-promises'
		);
		if (!reduce && 'IntersectionObserver' in window) {
			var io = new IntersectionObserver(function (entries) {
				entries.forEach(function (e) {
					if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
				});
			}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
			Array.prototype.forEach.call(targets, function (el, i) {
				// Léger décalage entre éléments voisins.
				var sib = el.parentElement ? Array.prototype.indexOf.call(el.parentElement.children, el) : 0;
				el.style.transitionDelay = Math.min(sib, 4) * 80 + 'ms';
				el.classList.add('dp-reveal');
				io.observe(el);
			});
		}

		// Portfolio : filtres par type de projet.
		Array.prototype.forEach.call(document.querySelectorAll('.dp-pf'), function (wrap) {
			var btns = wrap.querySelectorAll('.dp-pf-filters button');
			Array.prototype.forEach.call(btns, function (b) {
				b.addEventListener('click', function () {
					var f = b.getAttribute('data-filter');
					Array.prototype.forEach.call(btns, function (x) { x.classList.toggle('is-active', x === b); });
					Array.prototype.forEach.call(wrap.querySelectorAll('.dp-pf-card'), function (c) {
						var types = (c.getAttribute('data-types') || '').split(' ');
						c.classList.toggle('is-hidden', f !== '*' && types.indexOf(f) === -1);
					});
				});
			});
		});

		// Menu de section : lien actif selon la position.
		var sub = document.querySelector('.dp-subnav__links');
		if (sub && 'IntersectionObserver' in window) {
			var links = sub.querySelectorAll('a[href^="#"]');
			var map = {};
			Array.prototype.forEach.call(links, function (a) {
				var t = document.getElementById(a.getAttribute('href').slice(1));
				if (t) { map[t.id] = a; }
			});
			var so = new IntersectionObserver(function (entries) {
				entries.forEach(function (e) {
					if (e.isIntersecting && map[e.target.id]) {
						Array.prototype.forEach.call(links, function (x) { x.classList.remove('is-active'); });
						map[e.target.id].classList.add('is-active');
					}
				});
			}, { rootMargin: '-40% 0px -55% 0px' });
			Object.keys(map).forEach(function (id) { so.observe(document.getElementById(id)); });
		}

		// Compteurs animés : « 48 h », « 100 % », « 2023 »…
		var nums = document.querySelectorAll('.dp-kpi-num');
		if (!reduce && 'IntersectionObserver' in window) {
			var co = new IntersectionObserver(function (entries) {
				entries.forEach(function (e) {
					if (!e.isIntersecting) { return; }
					co.unobserve(e.target);
					var el = e.target, txt = el.textContent, m = txt.match(/\d+/);
					if (!m) { return; }
					var end = parseInt(m[0], 10), start = end > 1000 ? end - 30 : 0, t0 = null, dur = 1400;
					function step(ts) {
						if (!t0) { t0 = ts; }
						var p = Math.min((ts - t0) / dur, 1), v = Math.round(start + (end - start) * (1 - Math.pow(1 - p, 3)));
						el.textContent = txt.replace(m[0], v);
						if (p < 1) { requestAnimationFrame(step); } else { el.textContent = txt; }
					}
					requestAnimationFrame(step);
				});
			}, { threshold: 0.6 });
			Array.prototype.forEach.call(nums, function (n) { co.observe(n); });
		}
	});
})();
