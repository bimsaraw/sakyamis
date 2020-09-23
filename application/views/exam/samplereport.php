
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/filter-control/bootstrap-table-filter-control.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/toolbar/bootstrap-table-toolbar.js"></script>


<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css" />
<script type="text/javaScript">

function detailFormatter(index, row) {
    var html = [];
    $.each(row, function (key, value) {
        html.push('<p><b>' + key + ':</b> ' + value + '</p>');
    });
    return html.join('');
}

function DoOnCellHtmlData(cell, row, col, data) {
    var result = "";
    if (typeof data != 'undefined' && data != "") {
      var html = $.parseHTML(data);

      $.each( html, function() {
          if ( typeof $(this).html() === 'undefined' )
              result += $(this).text();
          else if ( typeof $(this).attr('class') === 'undefined' || $(this).hasClass('th-inner') === true )
              result += $(this).html();
      });
    }
    return result;
}

$(function () {
    $('#toolbar').find('select').change(function () {
        $('#table').bootstrapTable('refreshOptions', {
            exportDataType: $(this).val()
        });
    });
})

$(document).ready(function()
{
  $('#table').bootstrapTable('refreshOptions', {
      exportOptions: {ignoreColumn: [0,1], // or as string array: ['0','checkbox']
                      onCellHtmlData: DoOnCellHtmlData}
  });
});

</script>

  <div class="container">
    <h1 align="center">Data</h1><br>
    <div id="toolbar">
      <select class="form-control">
        <option value="">Export Basic</option>
        <option value="all">Export All</option>
        <option value="selected">Export Selected</option>
      </select>
    </div>
    <table id="table"
      data-toggle="table"
      data-height="600"
      data-show-toggle="true"
      data-show-columns="true"
      data-show-export="true"
      data-click-to-select="true"
      data-toolbar="#toolbar"
      data-pagination="true"
      data-search="true"
      data-detail-view="true"
      data-detail-formatter="detailFormatter"
      data-filter-control="true"
      data-url="tableExport.json">
      <thead>
        <tr>
          <th data-field="checkbox"    data-checkbox="true"                                                      >           </th>
          <th data-field="Rank"        data-sortable="true"  data-filter-control="select"  data-visible="true"   >Rank       </th>
          <th data-field="Flag"        data-sortable="true"  data-filter-control="input"   data-visible="false"  >Flag       </th>
          <th data-field="Country"     data-sortable="true"  data-filter-control="select"  data-visible="true"   >Country    </th>
          <th data-field="Population"  data-sortable="true"  data-filter-control="select"  data-visible="false"  >Population </th>
          <th data-field="Date"        data-sortable="true"  data-filter-control="select"  data-visible="true"   >Date       </th>
          <th data-field="p_of_world"  data-sortable="true"  data-filter-control="select"  data-visible="false"  >% of world </th>
          <th data-field="Language"    data-sortable="true"  data-filter-control="select"  data-visible="true"   >Language   </th>
        </tr>
      </thead>
    </table>
  </div>