/**
 * @package     EtdBniFeedback
 *
 * @version     1.0.0
 * @copyright   Copyright (C) 2016 ETD Solutions. Tous droits réservés.
 * @license     http://etd-solutions.com/LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

import Base from "etdsolutions/base";
import Utils from "etdsolutions/utils";
import Reveal from "js/vendor/reveal.min";
import $ from "jquery";

class Survey extends Base {

    btnValidate;
    thanks;

    constructor(container, options) {

        options = Utils.extend({}, {
            token: '',
            last_page: 0,
            urls: {
                save: '',
                validate: ''
            },
            ajax: {
                dataType: "json",
                type: "POST",
                data: {}
            }
        }, options);

        super(container, options);

        this.btnValidate = document.getElementById('btn-validate');
        this.thanks      = document.getElementById('thanks');

        Reveal.initialize({
            controls: false,
            progress: true,
            slideNumber: true,
            history: false,
            keyboard: false,
            overview: false,
            touch: false,
            fragments: false,
            loop: false,
            help: false,
            transition: 'slide',
            transitionSpeed: 'fast',
            backgroundTransition: 'slide',
            width: "100%",
            height: "90%",
            margin: 0.05,
            minScale: 1,
            maxScale: 1
        });

        // On reprend à la bonne page.
        Reveal.slide(this.options.last_page);

        this.bindEvents();

    }

    bindEvents() {

        Utils.addEventListener(".btn-next", "click", (e) => {
            e.preventDefault();
            let target = e.target || e.srcElement;
            this.next(target);
        });

        Utils.addEventListener(".btn-prev", "click", (e) => {
            e.preventDefault();
            let target = e.target || e.srcElement;
            this.prev(target);
        });

        this.btnValidate.addEventListener('click', (e) => {
            e.preventDefault();
            this.validate();
        });

        return this;
    }

    prev() {

        document.getElementById('reveal-slides').scrollTop = 0;
        Reveal.prev();

    }

    next(btn) {

        btn.innerHTML = '<span class="fa fa-spinner fa-pulse fa-fw"></span> Enregistrement...';
        btn.disabled = true;

        let slide = Reveal.getCurrentSlide();
        let data  = Utils.serialize(slide);

        // On ajoute nos infos supplémentaires.
        data.token   = this.options.token;
        data.page_id = slide.getAttribute('data-page-id');

        $.ajax(this.options.urls.save, Utils.extend({}, this.options.ajax, {
            data: data
        })).done(function(json) {

            if (json.error) {

                if (json.message) {
                    alert("Une erreur est survenue\n" + json.message);
                } else {
                    alert("Une erreur est survenue.");
                }

                return;
            }

            document.getElementById('reveal-slides').scrollTop = 0;
            Reveal.next();

        }).fail(function(response) {

            if (response.responseJSON && response.responseJSON.message ) {
                alert("Une erreur est survenue\n" + response.responseJSON.message);
            } else if (response.status > 0) {
                alert("Une erreur est survenue.");
            }

            if (response.responseJSON && response.responseJSON.fields) {
                response.responseJSON.fields.forEach(function(field) {
                    let el = slide.querySelector('[name="' + field.field + '"]');
                    if (el) {
                        let parent = Utils.getElementParent(el, ".form-group");
                        if (parent) {
                            parent.classList.remove("has-warning", "has-danger", "has-success");
                            parent.classList.add("has-danger");
                        }
                    }
                });
            }

        }).always(function() {
            btn.disabled  = false;
            btn.innerHTML = 'Suivant <span class="fa fa-long-arrow-right"></span>';
        });

    }

    validate() {

        let btn = this.btnValidate;
        btn.innerHTML = '<span class="fa fa-spinner fa-pulse fa-fw"></span> Validation...';
        btn.disabled = true;

        let slide = Reveal.getCurrentSlide();
        let data  = Utils.serialize(slide);

        // On ajoute nos infos supplémentaires.
        data.token   = this.options.token;
        data.page_id = slide.getAttribute('data-page-id');

        $.ajax(this.options.urls.validate, Utils.extend({}, this.options.ajax, {
            data: data
        })).done((json) => {

            if (json.error) {

                if (json.message) {
                    alert("Une erreur est survenue\n" + json.message);
                } else {
                    alert("Une erreur est survenue.");
                }

                return;
            }

            this.thanks.style.display = 'block';
            setTimeout(() => {
                this.thanks.style.opacity = '0.95';
            }, 70);

        }).fail(function(response) {

            if (response.responseJSON && response.responseJSON.message ) {
                alert("Une erreur est survenue\n" + response.responseJSON.message);
            } else if (response.status > 0) {
                alert("Une erreur est survenue.");
            }

            if (response.responseJSON && response.responseJSON.fields) {
                response.responseJSON.fields.forEach(function(field) {
                    let el = slide.querySelector('[name="' + field.field + '"]');
                    if (el) {
                        let parent = Utils.getElementParent(el, ".form-group");
                        if (parent) {
                            parent.classList.remove("has-warning", "has-danger", "has-success");
                            parent.classList.add("has-danger");
                        }
                    }
                });
            }

        }).always(function() {
            btn.disabled  = false;
            btn.innerHTML = '<span class="fa fa-check"></span> Valider';
        });

    }

}

export default Survey;