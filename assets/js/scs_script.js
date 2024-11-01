jQuery(document).ready(function () {
  // tinymce.init({
  //   selector: "#myTextarea",
  //   placeholder: "Type here...",
  // });

  var check_cookie_form_data = new FormData();
  check_cookie_form_data.append("action", "check_cookie_set");
  jQuery.ajax({
    url: wpAjax.ajaxurl,
    type: "POST",
    dataType: "JSON",
    contentType: false,
    processData: false,
    data: check_cookie_form_data,
    success: function (data) {
      if (data) {
        jQuery(".scs-cookie-notice").css("display", "none");
      } else {
        scs_if_cookie_not_fount();
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      //var err = eval("(" + xhr.responseText + ")");
      console.log("Error: " + errorThrown);
    },
  });

  function modal_appender(
    location,
    text,
    button_background,
    button_color,
    button_text,
    button_action
  ) {
    var html =
      `
      <div class="scs-cookie-notice" style="background-color:` +
      button_background +
      `;"><span class="scs-cookie">🍪</span><p>` +
      text +
      `&nbsp;
      <a href="` +
      button_action +
      `" target="_blank">Cookie Policy</a>.</p> <button type="button" class="scs-accept-cookies" style="background-color:` +
      button_color +
      `;">` +
      button_text +
      `</button>
      <button type="button" class="scs-reject-cookies" style="background-color:` +
      button_color +
      `;">Reject</button>
    </div>`;
    if (location == "Header") {
      jQuery("body").prepend(html);
      jQuery(document).scroll(function(){
        var scroller = jQuery(this).scrollTop();
        if(scroller>50){
          jQuery(".scs-cookie-notice").addClass("scs-fixed-top");
        }else{
          jQuery(".scs-cookie-notice").removeClass("scs-fixed-top");

        }
      })
    } else {
      jQuery("body").append(html);
      jQuery(".scs-cookie-notice").addClass("scs-fixed-bottom");
    }
  }
  function scs_if_cookie_not_fount() {
    var form_data = new FormData();
    form_data.append("action", "scs_fetch_data");

    jQuery.ajax({
      url: wpAjax.ajaxurl,
      type: "POST",
      dataType: "JSON",
      contentType: false,
      processData: false,
      data: form_data,
      success: function (data) {
        modal_appender(
          data.scs_location,
          data.scs_text,
          data.scs_button_background,
          data.scs_button_color,
          data.scs_button_text,
          data.scs_button_action
        );
        setTimeout(cookies_modal, 1000);
        //console.log(data.id);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        //var err = eval("(" + xhr.responseText + ")");
        console.log("Error: " + errorThrown);
      },
    });
  }
  function cookies_modal() {
    jQuery(document).on("click", ".scs-accept-cookies", function () {
      var form_data = new FormData();
      form_data.append("action", "cookie_setter");
      form_data.append("cookie_setter", "scs_cookie_setter");
      jQuery.ajax({
        url: wpAjax.ajaxurl,
        type: "POST",
        dataType: "JSON",
        contentType: false,
        processData: false,
        data: form_data,
        success: function (data) {
          width = jQuery(".scs-cookie-notice").width();
          jQuery(".scs-cookie-notice").animate(
            {
              left: "-=" + width,
            },
            250,
            "linear",
            function () {
              // animation is complete, remove element from DOM
              jQuery(this).remove();
            }
          );
          console.log(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          //var err = eval("(" + xhr.responseText + ")");
          console.log("Error: " + errorThrown);
        },
      });
    });
    jQuery(".scs-reject-cookies").on("click", function () {
      jQuery(".scs-cookie-notice").css("display", "none");
    });
  }
});
