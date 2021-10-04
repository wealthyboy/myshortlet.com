(function($) {
  $.fn.loadProperties = function(opt) {
    var settings;

    settings = $.extend(
      {
        html: "jquery-html",
        target: "jquery-target",
        form: "jQuery-form",
        filter_url: "jquery_filter_url",
        form_data: "jquery-form-data",
        load_more: "jquery_load_more",
        load_more_url: "jquery_load_more_url",
        loggedInStatus: "jquery_loggedinstatus",
        no_of_products: "jquery-no-of-products",
        total_no_of_products: "jquery_no_of_products",
        form_sort_by: "jquery-sort-by-form-data",
        overlay: "jquery-overlay",
      },
      opt
    );

    contents = function(obj, clear_html) {
      $(settings.overlay).addClass("d-none");
      if (obj.empty) {
        $(this.container.selector).append(
          '<img class="no_product_found" src="/images/empty_product.svg">',
          '<p class="text-center">No Result Found!!!</p>'
        );
        $("span.show-items-count").text("");
      }
      try {
        var json = JSON.parse(obj);
      } catch (exception) {
        var json = null;
      }

      if (json) {
        var url = json.next_page_url;
        var data = json.data;
      } else {
        var data = obj.data;
        url = obj.next_page_url;
      }

      if (obj.next_page_url) {
        $(".load_more")
          .removeClass("d-none")
          .attr("href", obj.next_page_url);
      } else {
        $(".load_more").addClass("d-none");
      }

      displayHtml(data, clear_html);
    };

    //filter search

    showNoOfProducts = function(data, obj) {
      if (data != undefined) {
        $(".show-items-count").text(
          "Showing items 1 to " + obj.to + " of " + obj.total + " total"
        );
      }
    };

    formatNumber = function(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    displayHtml = function(data, clear_html = false) {
      let col = null;
      let html = "";
      if (data.length == 0) {
        html = "";
      } else {
        for (let i in data) {
          html += '<div class="position-relative loaded-apartments">';
          html += '<div class="row no-gutters">';
          html += '<div class="col-md-3 position-relative">';
          html += "<div>";
          html +=
            '<a href=""><img src="' +
            data[i].image_m +
            '" class="img  img-fluid"></a>';
          html += '<div class="fav-icon position-absolute">';
          html +=
            '<a href="#" data-id="189" data-toggle="loggedIn" data-target="#auth" title="Wishlist" class="saved">';
          html +=
            '<svg id="saved-outline" class="d-none"><use xlink:href="#favorites-outline"></use></svg>';
          html +=
            '<svg id="saved-none-outline"><use xlink:href="#favorites"></use></svg>';
          html += "</a>";
          html += "</div>";
          html += "</div>";
          html += "</div>";
          html += '<div class="col-md-9 position-relative col-12 pl-3">';
          html += '<div class="d-flex  justify-content-between">';
          html += '<div><a href="">' + data[i].name + "</a></div>";
          html += '<div class="d-block d-sm-none">';
          html += "<span>₦5000/ night</span>";
          html += "</div>";
          html += "</div>";
          html += "<div class='ap-location'>";
          html += "<small>";
          html +=
            '<a href="" class="p-0">' +
            data[i].city +
            '</a>,  <a href="">' +
            data[i].state +
            "</a></small></div>";
          html += '<div class="mb-5">';
          html += "<div><span> Air condition</span></div>";
          html += "";
          html += "<div>";
          html += "<span>10 guests</span>";
          html += '<span aria-hidden="true"> · </span>';
          html += '<span>2 bedroom</span> <span aria-hidden="true"> · </span>';
          html += "<span>2 baths</span>";
          html += "</div>";
          html += "</div>";
          html +=
            '<div class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end">';
          html += "<div>3 reviews</div>";
          html += "";
          html +=
            '<div class="d-none d-lg-block d-xl-block text-right mr-2"><span>₦5000 / night</span>';
          html +=
            '<a href="" class="btn btn-primary btn-round d-none d-lg-block d-xl-block">Check Availability  <i class="material-icons">arrow_forward_ios</i></a>';
          html += "</div></div></div></div></div>";
        }
      }

      if (clear_html) {
        $("#" + settings.target)
          .html("")
          .append(html);
        return;
      } else {
        $("#load-products .col-6:last").after(html);
        return;
      }
    };

    function filter(form, url) {
      $.ajax({
        url: url,
        type: "get",
        cache: false,
      })
        .done(function(json) {
          contents(json.properties, true);
        })
        .fail(function() {
          alert("Posts could not be loaded.");
        });
    }

    loadMore = function(url, data = null) {
      $.ajax({
        url: url,
        data: data,
        type: "get",
        cache: false,
        beforeSend: function(xhr) {},
      })
        .done(function(json) {
          contents(json.properties, false);
          //$(".spinner-grow-md").addClass("d-none");
        })
        .fail(function() {
          alert("Something went wrong.");
        });
    };

    buildUrl = function() {
      let sort_by = settings.form_sort_by.serializeArray().shift();
      const qs = [];
      if (sort_by.value !== "") {
        qs.push(sort_by.name + "=" + sort_by.value);
      }
      settings.form.serializeArray().forEach((element) => {
        qs.push(element.name + "=" + element.value);
      });
      window.history.pushState({}, "", "?" + qs.join("&"));
    };

    qS = function() {
      const url = new URL(window.location);
      return url.search.toString();
    };

    $(document).ready(function() {
      settings.form.click(function() {
        $(".ap-loaders").removeClass("d-none");
        $(".loaded-apartments").remove();
        buildUrl();
        filter(settings.form_data, window.location);
      });

      $(document).on("click", ".load_more", function(e) {
        e.preventDefault();
        $(document)
          .find(".spinner-grow-md")
          .removeClass("d-none");
        var href = $(this).attr("href");
        window.history.pushState({}, "", href);
        loadMore(href, (data = null));
      });

      settings.form_sort_by.change(function() {
        const url = new URL(window.location);
        let arr = settings.form_sort_by.serializeArray().shift();
        url.searchParams.set(arr.name, arr.value);
        window.history.pushState({}, "", url);
        filter(settings.form_sort_by, window.location);
      });
    });

    return this;
  }; //$.fn
})(jQuery);
