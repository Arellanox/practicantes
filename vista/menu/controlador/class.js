class GuardarArreglo {
  array = new Array();
  selectID;
  guardado;
  acumulativo = 0;

  constructor(array) {
    this.array = array
  }
  //Guarda el arreglo
  get array() {
    return this.array;
  }
  set array(newArray) {
    // newName = newName.trim();
    // console.log(newArray)
    if (Array.isArray(newArray)) {
      this.array = newArray;
    }
  }

  //Guarda el seleccionado
  set selectID(id) {
    if (true) {
      this.selectID = id;
    }
  }

  get selectID() {
    return this.selectID;
  }

  //Guarda el seleccionado
  setguardado(id) {
    if (true) {
      this.guardado = id;
    }
  }

  getguardado() {
    return this.guardado;
  }

  acumularSuma(number, reset = false) {
    // check if the passed value is a number
    if (typeof x == 'number' && !isNaN(x)) {
      // check if it is integer
      if (Number.isInteger(x)) {
        this.acumulativo += number;
        return 1
      } else {
        this.acumulativo += number;
        return 1
      }
    } else {
      try {
        if (parseInt(number)) {
          this.acumulativo += parseInt(number);
          return 1
        } else {
          if (reset)
            this.acumulativo = 0;
          return 0
        }
      } catch (error) {

      }
    }
  }

  acumularResta(number) {
    this.acumulativo -= number;
  }

  get acumular() {
    return this.acumulativo;
  }

}

const objectoArreglo = new GuardarArreglo([1, 2, 3, 4])

var Base64 = (function () {

  var ALPHA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

  var Base64 = function () { };

  var _encode = function (value) {

    if (typeof (value) !== 'number') {
      throw 'Value is not number!';
    }

    var result = '',
      mod;
    do {
      mod = value % 64;
      result = ALPHA.charAt(mod) + result;
      value = Math.floor(value / 64);
    } while (value > 0);

    return result;
  };

  var _decode = function (value) {

    var result = 0;
    for (var i = 0, len = value.length; i < len; i++) {
      result *= 64;
      result += ALPHA.indexOf(value[i]);
    }

    return result;
  };

  Base64.prototype = {
    constructor: Base64,
    encode: _encode,
    decode: _decode
  };

  return Base64;

})();







class TableNew {

  tableID;
  status;
  dataAjax;
  api;
  renderTable;

  //Variables propias
  table = false;


  constructor(tableID = 'FormId') {
    // this.array = array
    this.renderTable = render;
  }


  createTable(dataAjax, api, columns, columnsDefs) {
    this.dataAjax = dataAjax;
    this.columns = columns;
    this.api = api;
    this.columnDefs = columnsDefs

    if (!$.fn.DataTable.isDataTable(`#${tableID}`))
      this.table = $(`#${this.tableID}`).DataTable({
        language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
        scrollY: autoHeightDiv(0, 374),
        scrollCollapse: true,
        lengthChange: false,
        // info: false,
        paging: false,
        ajax: {
          dataType: 'json',
          data: function (d) { return $.extend(d, this.dataAjax); },
          method: 'POST',
          url: `${http}${servidor}/${appname}/api/${this.api}.php`,
          beforeSend: function () { },
          complete: function () { resolve(1) },
          error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
          },
          dataSrc: 'response.data'
        },
        columns: this.columns,
        columnDefs: this.columnDefs,
      })
  }

  actualizarTable() {
    this.table.ajax.reload();
  }


}