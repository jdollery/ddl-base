const styles = [
  'color: white',
  'background: #1171ae',
  'padding: 10px 15px',
].join(';');

console.info('%cSite designed and developed by Dental Design - dental-design.marketing', styles);


/*-----------------------------------------------------------------------------------*/
/* FORCE PAGE RELOAD TO STOP SAFARI & EDGE PAGE CHACHE */
/*-----------------------------------------------------------------------------------*/

window.onpageshow = function(event) {
  if (event.persisted) {
    window.location.reload()
  }
};


/*-----------------------------------------------------------------------------------*/
/* HEADER RESIZE VARIABLE */
/*-----------------------------------------------------------------------------------*/

let headerSize = document.querySelector('.header');

let headerLoad = headerSize.offsetHeight;
document.documentElement.style.setProperty('--header-height', `${headerLoad}px`);
document.documentElement.style.setProperty('--vh', (window.innerHeight*.01) + 'px');

window.onresize = function(event) {

  let headerResize = headerSize.offsetHeight;
  document.documentElement.style.setProperty('--header-height', `${headerResize}px`);
  document.documentElement.style.setProperty('--vh', (window.innerHeight*.01) + 'px'); //mob/tablet window height fix

};


jQuery(document).ready(function () { //doc ready start

  /*-----------------------------------------------------------------------------------*/
  /* STICKY NAV */
  /*-----------------------------------------------------------------------------------*/

  jQuery(function(){
    setSticky();
    jQuery(window).scroll(setSticky);
  });

  function setSticky() {
    if (jQuery(window).scrollTop() > 1) {
      jQuery('#mainHeader').addClass("header--sticky");
    }
    else{
      jQuery('#mainHeader').removeClass("header--sticky");
    }
  }


  /*-----------------------------------------------------------------------------------*/
  /* RESPONSIVE NAV */
  /*-----------------------------------------------------------------------------------*/

  jQuery('.navigation li').parent().find("ul").addClass('sub-menu');
  jQuery('.sub-menu').parent().addClass('menu-item-has-children');

  var customToggle = document.getElementById('navToggle');

  var nav = responsiveNav("#headerNav", {
    customToggle: "#navToggle", // Selector: Specify the ID of a custom toggle
    enableFocus: true,
    enableDropdown: true,
    openDropdown: '<span class="hidden">Open sub menu</span>',
    closeDropdown: '<span class="hidden">Close sub menu</span>',
    
    // open: function () {
    //   customToggle.innerHTML = '<div class="burger__inner"><div class="burger__trigger"><span class="burger__icon"></span></div><div class="burger__text">Close</div></div>';
    // },
    // close: function () {
    //   customToggle.innerHTML = '<div class="burger__inner"><div class="burger__trigger"><span class="burger__icon"></span></div><div class="burger__text">Menu</div></div>';
    // },
    
    resizeMobile: function () {
      customToggle.setAttribute( 'aria-controls', 'headerNav' );
    },
    
    resizeDesktop: function () {
      customToggle.removeAttribute( 'aria-controls' );
    },
    
  });

  var close = document.getElementById("viewOverlay");
  close.addEventListener("click", function () {
    nav.close();
  }, false);


  /*-----------------------------------------------------------------------------------*/
  /* SLICK SLIDER */
  /*-----------------------------------------------------------------------------------*/

    // jQuery('#testimonialSlider').slick({
    //   slidesToShow: 1,
    //   slidesToScroll: 1,
    //   centerMode: true,
    //   autoplay: true,
    //   autoplaySpeed: 3000,
    //   fade: true,
    //   swipe: false,
    //   pauseOnHover: false,
    //   pauseOnFocus: false,
    //   focusOnSelect: true,
    //   dots: false,
    //    arrows: true,
    //    prevArrow: jQuery('#arrowPrev'),
    //    nextArrow: jQuery('#arrowNext'),
    //   rows: 0 // Fix to remove extra div v1.8.0-1
    // });

    
  /*-----------------------------------------------------------------------------------*/
  /* ACCORDION */
  /*-----------------------------------------------------------------------------------*/

  jQuery("#dropItem > dt").on("click", function() {
    if (jQuery(this).hasClass("accordion__term--open")) {
      jQuery(this).removeClass("accordion__term--open");
      jQuery(this).siblings("button").attr("aria-expanded","false");
      jQuery(this).siblings("dd").slideUp(200);
    } else {
      jQuery("#dropItem > dt").removeClass("accordion__term--open");
      jQuery(this).addClass("accordion__term--open");
      jQuery(this).siblings("button").attr("aria-expanded","true");
      jQuery("#dropItem > dd").slideUp(200);
      jQuery(this).siblings("dd").slideDown(200);
    }
  });


  /*-----------------------------------------------------------------------------------*/
  /* TEAM SLIDEOUT */
  /*-----------------------------------------------------------------------------------*/

  // Open Team Member Slideout
	jQuery('[data-open]').on('click', function () {
		var member_id = jQuery(this).attr('data-open');
		jQuery('[data-sideout="' + member_id + '"]').addClass('active');
		jQuery('html').addClass('slideout-active');
	});

	// Close Team Member Slideout
	jQuery('[data-close]').on('click', function () {
		var member_id = jQuery(this).attr('data-close');
		jQuery('[data-sideout="' + member_id + '"]').removeClass('active');
		jQuery('html').removeClass('slideout-active');
	});

  // Open Team Member With Hash
  const current_url = location.hash
  const member_slug = current_url.replace('#','')

  if (current_url) {

    jQuery('html, body').animate({
      scrollTop: jQuery('[data-member="' + member_slug + '"]').offset().top + -150
    }, 'slow');

		jQuery('[data-sideout="' + member_slug + '"]').addClass('active');
    jQuery('html').addClass('slideout-active');

  }


  /*-----------------------------------------------------------------------------------*/
  /* CONTACT FORM */
  /*-----------------------------------------------------------------------------------*/

  jQuery('select').select2({
    minimumResultsForSearch: Infinity,
    placeholder: function(){
      jQuery(this).data('placeholder');
    }
  });

  //Initialize the validation object which will be called on form submit.
  var validobj = jQuery("#validateForm").validate({

    onkeyup: false,
    errorClass: "error",
    errorElement: 'strong',

    // errorPlacement: function (error, element) {
    //   var elem = jQuery(element);
    //   error.insertAfter(element);
    // },

    highlight: function (element, errorClass, validClass) {
      var elem = jQuery(element);
      if (elem.hasClass("select2-hidden-accessible")) {
        jQuery(".select2-container").addClass(errorClass);
      } else {
        elem.addClass(errorClass);
      }
    },

    unhighlight: function (element, errorClass, validClass) {
      var elem = jQuery(element);
      if (elem.hasClass("select2-hidden-accessible")) {
        jQuery(".select2-container").removeClass(errorClass);
      } else {
        elem.removeClass(errorClass);
      }
    }

  });

  jQuery(document).on("change", ".select2-hidden-accessible", function () {
    if (!jQuery.isEmptyObject(validobj.submitted)) {
      validobj.form();
    }
  });

  jQuery(document).on("select2-opening", function () {
    if (jQuery(".select2-container").hasClass("error")) {
      jQuery(".select2-drop ul").addClass("error");
    } else {
      jQuery(".select2-drop ul").removeClass("error");
    }
  });

  $.validator.addMethod('filesize', function(value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
  }, 'File size must be less than 5mb');

}); //doc ready end


/*-----------------------------------------------------------------------------------*/
/* ACCESSIBILITY CONTROLS */
/*-----------------------------------------------------------------------------------*/

const pressed = document.querySelectorAll('[aria-pressed]');

pressed.forEach(function(press) {

  press.addEventListener('click', (e) => {  
    let pressed = e.target.getAttribute('aria-pressed') === 'true';
    e.target.setAttribute('aria-pressed', String(!pressed));
  });

});

const expanded = document.querySelectorAll('[aria-expanded]');

expanded.forEach(function(expand) {

  expand.addEventListener('click', (e) => {  
    let expanded = e.target.getAttribute('aria-expanded') === 'true';
    e.target.setAttribute('aria-expanded', String(!expanded));
  });

});


/*-----------------------------------------------------------------------------------*/
/* CUSTOM FILE UPLOAD */
/*-----------------------------------------------------------------------------------*/

const inputs = document.querySelectorAll( '.upload' );

inputs.forEach(function(input) {

  let label	 = input.nextElementSibling;
  let labelVal = label.innerHTML;

  input.addEventListener( 'change', function(e){

    let fileName = '';

    if( this.files && this.files.length > 1 ) {
      fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
    } else {
      fileName = e.target.value.split( '\\' ).pop();
    }

    if( fileName ) {
      label.querySelector( '.upload__file' ).innerHTML = fileName;
      // console.log(fileName);
    } else {
      label.innerHTML = labelVal;
      // console.log(labelVal);
    }
  });

  // Firefox bug fix
  input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
  input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });

});


inputs.forEach(function(input) {

  let label	 = input.nextElementSibling;
  // console.log(label)

});


/*-----------------------------------------------------------------------------------*/
/* SCROLL TO ANCHOR */
/*-----------------------------------------------------------------------------------*/

// https://stackoverflow.com/questions/7717527/smooth-scrolling-when-clicking-an-anchor-link

jQuery('a[href*="#"]')
// Remove links that don't actually link to anything
.not('[href="#"]')
.not('[href="#0"]')
.click(function(event) {
  // On-page links
  if (
    location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
    && 
    location.hostname == this.hostname
  ) {
    // Figure out element to scroll to
    var target = jQuery(this.hash);
    target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
    // Does a scroll target exist?
    if (target.length) {
      // Only prevent default if animation is actually gonna happen
      event.preventDefault();
      jQuery('html, body').animate({
        scrollTop: target.offset().top-165
      }, 1000, function() {
        // Callback after animation
        // Must change focus!
        var $target = jQuery(target);
        $target.focus();
        if ($target.is(":focus")) { // Checking if the target was focused
          return false;
        } else {
          $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
          $target.focus(); // Set focus again
        };
      });
    }
  }
  return false;
});


/*-----------------------------------------------------------------------------------*/
/* INIT WOW */
/*-----------------------------------------------------------------------------------*/

// function afterReveal (element) {
// 	if (element.classList.contains('trigger')) {
// 		element.addEventListener('animationend', function () {
// 			console.log('This runs once finished!');
//       // element.style.opacity ='1';
// 		});
// 	}
// }

// wow = new WOW(
//   {
//     boxClass: 'wow',      // default
//     animateClass: 'animated', // default
//     offset: 0,          // default
//     mobile: true,       // default
//     live: true,        // default
//     callback: afterReveal
//   }
// )
// wow.init();


/*-----------------------------------------------------------------------------------*/
/* VIDEO POP-UP */
/*-----------------------------------------------------------------------------------*/

document.querySelectorAll("#videoToggle").forEach((d) => d.addEventListener("click", playVideos));

const html = document.querySelector("html");

function playVideos(e) {

  videoDialog(e.currentTarget.dataset.url);

  html.classList.add("js-dialog-active");

  var videoWrap = document.createElement("DIV");
  videoWrap.setAttribute("id", "videoWrap");
  videoWrap.setAttribute("class", "dialog");
  document.body.appendChild(videoWrap);

  const wrapper = document.getElementById("videoWrap");

  window.setTimeout(function(){wrapper.classList.add("dialog--active");}, 10);

  const url = this.dataset.url;

  const startModal = '<span onclick="videoDialogClose();" class="dialog__overlay"></span> <div class="dialog__inner">';
  const finishModal = '<button onclick="videoDialogClose();" class="dialog__close"><span class="icon icon--close"><svg role="img"><use xlink:href="#close" href="#close"></use></svg></span></button></div>';
  
  if (url.indexOf("mp4") !== -1 || url.indexOf("m4v") !== -1) {
    
    document.getElementById(
      "videoWrap"
    ).innerHTML = `${startModal}<video controls loop playsinline autoplay><source src='${this.dataset.url}' type="video/mp4"></video>${finishModal}`;
  } else {
    alert("No video link found.");
  }

}

const videoDialogClose = () => {
  html.classList.remove("js-dialog-active");

  const wrapper = document.getElementById("videoWrap");
  wrapper.parentNode.removeChild(wrapper);

};


function videoDialog(){}


/*-----------------------------------------------------------------------------------*/
/* TREATMENT SELECT */
/*-----------------------------------------------------------------------------------*/

// document.querySelectorAll("[name=test_redirect]")[0].addEventListener('change', function () {
//   window.location = "https://www.bbc.co.uk/" + this.value;
// });

// let selectList = null;
// let listButton = null;

// let treatmentSelect = document.getElementById("treatmentSelect");

// if (treatmentSelect) {

//   window.addEventListener("DOMContentLoaded", getElements);

//   function getElements(e){
//     selectList = document.getElementById("treatmentSelect");
//     listButton = document.getElementById("treatmentButton");
//     listButton.addEventListener("click", clickHandler);
//   }

//   function clickHandler(e){
//     if(selectList.value!="select"){
//       var win = window.open(selectList.value,"_top");
//     } else {
//       alert("Chose between the three options!");
//     }
//   }

// }


/* ---- Example ---- */

/* <select 
  id="treatmentSelect" 
  name="specialist_treatment" 
  data-placeholder="Choose a specialist treatment" 
  >
  <option></option>
  <option label="Emergency dentistry" value="<?php echo get_the_permalink( 66 ) ?>">Emergency dentistry</option>
  <option label="Dental implants" value="<?php echo get_the_permalink( 432 ) ?>">Dental implants</option>
  <option label="Invisalign treatment" value="<?php echo get_the_permalink( 118 ) ?>">Invisalign treatment</option>
  <option label="Root canal treatment" value="<?php echo get_the_permalink( 119 ) ?>">Root canal treatment</option>
  <option label="Cosmetic dentistry" value="<?php echo get_the_permalink( 120 ) ?>">Cosmetic dentistry</option>
</select>

<button class="btn btn--yellow btn--sm" id="treatmentButton">Go!</button> */


/*-----------------------------------------------------------------------------------*/
/* DIALOGS */
/*-----------------------------------------------------------------------------------*/

// const dialogs = document.querySelectorAll('[data-dialog]');

// dialogs.forEach(function(trigger) {

//   trigger.addEventListener('click', function(event) {

//     event.preventDefault();

//     const dialog = document.getElementById(trigger.dataset.dialog);

//     dialog.classList.add('dialog--active');
//     html.classList.add("js-dialog-active");
//     const exits = dialog.querySelectorAll('#dialogClose');

//     exits.forEach(function(exit) {

//       exit.addEventListener('click', function(event) {

//         event.preventDefault();
//         dialog.classList.remove('dialog--active');
//         html.classList.remove("js-dialog-active");

//       });

//     });

//   });

// });


/*-----------------------------------------------------------------------------------*/
/* ANCHOR TRIGGER */
/*-----------------------------------------------------------------------------------*/

const anchorTrigger = document.querySelectorAll('a');

anchorTrigger.forEach(function(trigger) {

  if (trigger.hash) {

    trigger.addEventListener('click', function() {

      window.open(this.href, '_self'); return false;

    });

  }

});