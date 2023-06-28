jQuery(function ($) {
  $(document).ready(function () {
    if ($(".esret-datatable").length > 0) {
      $(".esret-datatable").DataTable({
        "lengthMenu": [
          [25, 50, 100, 200, -1],
          [25, 50, 100, 200, "All"]
        ],
        "pageLength": 100,
        order: [[0, "desc"]],
        "aoColumnDefs": [
          {"bSortable": false, "aTargets": ["no-sort"]}
        ],
        dom: "lBfrtip",
        buttons: [],
        columnDefs: [{
          "targets": "no-sort",
          "orderable": false
        }],
        initComplete: function () {
          this.api().columns().every(function () {
            var column = this;
            var multiple_filters = $(column.header()).hasClass("esret-multiple-filters");

            $(column.header()).data("label", $(column.header()).text());
            if (!$(column.header()).hasClass("esret-filter-disabled")) {
              var select = $("<select><option value=\"\">" + $(column.header()).text() + "</option></select>")
              .appendTo($(column.header()).empty())
              .on("change", function () {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );

                if (multiple_filters) {
                  column
                  .search(val ? val + "+" : "", true, false)
                  .draw();
                } else {
                  column
                  .search(val ? "^" + val + "$" : "", true, false)
                  .draw();
                }
              });

              var mf_data = [];

              column.data().unique().sort().each(function (d) {
                if (multiple_filters) {
                  $.each(d.split("<br>"), function (k, t) {
                    if (t !== "") {
                      if ($.inArray(t, mf_data) === -1) {
                        select.append("<option value=\"" + t + "\">" + t + "</option>");
                        mf_data.push(t);
                      }
                    }
                  });
                } else {
                  if (d !== "") {
                    select.append("<option value=\"" + d + "\">" + d + "</option>");
                  }
                }
              });
            }
          });
        }
      });
    }

    $("body").on("change", "select[name=email_type]", function () {
      var option = $("select[name=\"email_type\"] option[value=\"" + $(this).val() + "\"]");
      esret_change_tags($(".esret-title-tags-table"), option.data("tags-title"));
      esret_change_tags($(".esret-body-tags-table"), option.data("tags-body"));
    });

    function esret_change_tags(el, tags) {
      el.empty();
      $.each(tags, function (k, v) {
        if ((v.type !== undefined) && (v.type === "double")) {
          el.append("<tr><td>[" + v.tag + "][/" + v.tag + "]</td><td>" + v.description + "</td></tr>");
        } else {
          el.append("<tr><td>[" + v.tag + "]</td><td>" + v.description + "</td></tr>");
        }
      });
    }
  });
});
