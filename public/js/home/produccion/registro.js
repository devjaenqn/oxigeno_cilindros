/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 70);
/******/ })
/************************************************************************/
/******/ ({

/***/ 70:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(71);


/***/ }),

/***/ 71:
/***/ (function(module, exports) {

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

//VALIDAR TIEMPO 00-24
//var g = RegExp('([01]+[0-9]|2[0-3])')
//var g = RegExp('([01]+[0-9]|2[0-3]):[0-5][0-9]')
var registro = {
  template: '#vue_produccion_registro',
  data: function data() {
    return _extends({}, data_vue, {
      // lote_success: false,
      // serie_lote: '',
      // numero_lote: '',
      // fecha: moment().format('YYYY-MM-DD'),
      // fecha_salida: moment().format('YYYY-MM-DD'),
      // operador: 0,
      // turno: '7AM - 7PM',
      // entrada: '00:00',
      // salida: '00:00',
      // observacion: '',
      cilindro_th: null,
      // sistema: 0,
      // total_cilindros: 0,
      // total_libras: 0,
      // cilindros: [],
      cilindro: {
        marcar_salida: false,
        id: 0,
        serie: '',
        codigo: '',
        capacidad: 0,
        propietario: '',
        propietario_id: 0,
        observacion: '',
        cantidad: 0,
        registrado: 0,
        delete: true,
        ingreso: moment().format('YYYY-MM-DD HH:mm:ss'),
        salida: moment().format('YYYY-MM-DD HH:mm:ss'),
        salida_date: moment().format('YYYY-MM-DD'),
        salida_time: '00:00'
      }
    });
  },


  methods: {
    resetForm: function resetForm() {
      var _this2 = this;

      this.entrada = '00:00';
      this.salida = '00:00';

      this.cilindros = [];
      this.operador = 0;
      this.observacion = '';
      //recarar correlativos
      axios.get(BASE_URL + '/home/recursos/sistemas').then(function (res) {
        _this2.data_sistemas = res.data;
        if (res.data.length > 0) {
          var sis = res.data[0];
          _this2.sistema = sis.sis_id;
          if (sis.lote != null) {
            _this2.serie_lote = sis.lote.serie;
            _this2.lote_success = true;
            _this2.numero_lote = sis.lote.actual;
          }
        }
      });
    },
    resetCilindro: function resetCilindro() {
      this.cilindro_th.typeahead('val', '');
      this.$refs.cilindro_th.focus();
      this.cilindro.id = 0;
      this.cilindro.serie = '';
      this.cilindro.codigo = '';
      this.cilindro.capacidad = 0;
      this.cilindro.propietario = '';
      this.cilindro.propietario_id = 0;
      this.cilindro.cantidad = 0;
      this.cilindro.registrado = 0;
      this.cilindro.retiro = '0';
      this.cilindro.delete = true;
      this.cilindro.salida_date = this.fecha;
      this.cilindro.observacion = '';
      this.cilindro.salida_time = this.salida;
    },
    findLote: function findLote(sistema_id) {
      var sis = this.data_sistemas.find(function (v) {
        return v.sis_id == sistema_id;
      });
      return typeof sis != 'undefined' ? sis.lote : null;
      // console.log(sis)
      // let lote = this.data_lotes.find(v => {
      //   return v.sistema_attr == sis.attr
      // })
      // console.log(lote)
    },
    cilindroExiste: function cilindroExiste(cilindro_id) {
      var target = this.cilindros.find(function (v) {
        return v.id == cilindro_id;
      });
      return typeof target != 'undefined';
    },
    frmOnSubmit_frmRegistro: function frmOnSubmit_frmRegistro() {
      var _this3 = this;

      msg.pregunta('Producción', '¿Desea continuar?', function (quest) {
        if (quest) {
          var now = moment();
          // let entrada = moment(now.format('YYYY-MM-DD') + ' ' + this.entrada)
          // let salida = moment(now.format('YYYY-MM-DD') + ' ' + this.salida)
          var entrada = moment(_this3.fecha + ' ' + _this3.entrada);
          var salida = moment(_this3.fecha_salida + ' ' + _this3.salida);

          if (_this3.lote_success) {
            if (entrada.isValid() && salida.isValid()) {
              var success_reg = true;

              if (entrada >= salida) {
                success_reg = false;
                toastr.warning('La fecha de salida debe ser mayor', 'Revisar');
              }

              if (_this3.operador == 0) {
                success_reg = false;
                toastr.warning('Seleccione un operador', 'Revisar');
              }

              if (_this3.cilindros.length <= 0) {
                success_reg = false;
                toastr.warning('Registre al menos un cilindro', 'Revisar');
              }

              if (success_reg) {
                var sendData = {
                  entrada: entrada.format('YYYY-MM-DD HH:mm:ss'),
                  salida: salida.format('YYYY-MM-DD HH:mm:ss'),
                  cilindros: _this3.cilindros,
                  operador: _this3.operador,
                  turno: _this3.turno,
                  fecha: _this3.fecha,
                  registrado: _this3.registrado,
                  sistema: _this3.sistema,
                  observacion: _this3.observacion,
                  total_cilindros: _this3.total_cilindros,
                  total_libras: _this3.total_libras,
                  modo: 'none'
                };

                if (!_this3.edit) return axios.post(BASE_URL + '/api/produccion', sendData);else {
                  sendData.modo = 'produccion';
                  return axios.put(BASE_URL + '/api/produccion/' + _this3.produccion_id, sendData);
                }
              }
            } else {
              //fechas invalidas
              toastr.warning('Fechas no válidas', 'Revisar');
            }
          } else {
            //no existe lote
            toastr.error('Lote no encontrado', 'Error');
          }
        }
      }).then(function (res) {
        if (res.data) {
          if (res.data.success) {
            // toastr.success('Registro realizado con éxito', 'Producción - Success')
            var title = '',
                text = '';
            if (_this3.edit) {
              title = 'Actualizado';
              text = 'Producción actualizada';
            } else {
              title = 'Registrado';
              text = 'Datos registrado';
            }
            msg.success(title, text, 5000).then(function (event) {
              location.href = base_url('home/produccion');
            });
          }
        }
      }).catch(function (err) {
        if (err.response) toastr.error(err.response.data.message + '\n' + err.response.data.file + ' - ' + err.response.data.line);else toastr.error(err);
      });
      // msg.pregunta('Producción', '¿Desea continuar?').then(res => {
      //   if (res) {
      //     loading.show()
      //     let now = moment()
      //     // let entrada = moment(now.format('YYYY-MM-DD') + ' ' + this.entrada)
      //     // let salida = moment(now.format('YYYY-MM-DD') + ' ' + this.salida)
      //     let entrada = moment(this.fecha + ' ' + this.entrada)
      //     let salida = moment(this.fecha_salida + ' ' + this.salida)

      //     if (this.lote_success) {
      //       if (entrada.isValid() && salida.isValid()){
      //         let success_reg = true

      //         if (entrada >= salida) {
      //           success_reg = false
      //           toastr.warning('La fecha de salida debe ser mayor', 'Revisar')
      //         }

      //         if (this.operador == 0) {
      //           success_reg = false
      //           toastr.warning('Seleccione un operador', 'Revisar')
      //         }

      //         if (this.cilindros.length <= 0) {
      //           success_reg = false
      //           toastr.warning('Registre al menos un cilindro', 'Revisar')
      //         }

      //         if (success_reg) {
      //           let sendData = {
      //             entrada: entrada.format('YYYY-MM-DD HH:mm:ss'),
      //             salida: salida.format('YYYY-MM-DD HH:mm:ss'),
      //             cilindros: this.cilindros,
      //             operador: this.operador,
      //             turno: this.turno,
      //             fecha: this.fecha,
      //             registrado: this.registrado,
      //             sistema: this.sistema,
      //             observacion: this.observacion,
      //             total_cilindros: this.total_cilindros,
      //             total_libras: this.total_libras,
      //             modo: 'none'
      //           }
      //           _this = this
      //           function __fnOnSuccess (res) {
      //             console.log(this.edit)
      //             loading.hide()
      //             if (res.data.success) {
      //               // toastr.success('Registro realizado con éxito', 'Producción - Success')
      //               let title = '', msg = ''
      //               if (_this.edit) {
      //                 title = 'Actualizado'
      //                 msg = 'Producción actualizada'
      //               } else {
      //                 title = 'Registrado'
      //                 msg = 'Datos registrado'
      //               }
      //               swal({
      //                 title: title,
      //                 text: msg,
      //                 type: 'success',
      //                 timer: 2000,
      //                 allowOutsideClick: false
      //               }).then(event => {
      //                 location.href = base_url('home/produccion')
      //               })
      //             }
      //           }
      //           function __fnOnError (res) {
      //             loading.hide()
      //             toastr.error(err.response.data.message + '\n' + err.response.data.file + ' - ' + err.response.data.line)
      //           }
      //           if (!this.edit)
      //             axios.post(BASE_URL + '/api/produccion', sendData).then(__fnOnSuccess).catch(__fnOnError)
      //           else{
      //             sendData.modo = 'produccion'
      //             axios.put(BASE_URL + '/api/produccion/' + this.produccion_id, sendData).then(__fnOnSuccess).catch(__fnOnError)
      //           }
      //         } else {
      //           loading.hide()
      //         }
      //       } else {
      //         loading.hide()
      //         //fechas invalidas
      //         toastr.warning('Fechas no válidas', 'Revisar')
      //       }
      //     } else {
      //       loading.hide()
      //       //no existe lote
      //       toastr.error('Lote no encontrado', 'Error')
      //     }
      //   }
      // })
    },
    frmOnSubmit_frmAgregaCilindro: function frmOnSubmit_frmAgregaCilindro() {
      console.log('registrar cilindro');
      if (!this.cilindroExiste(this.cilindro.id)) {
        if (this.cilindro.id != 0) {
          var success = true;
          var entrada = moment(this.fecha + ' ' + this.entrada);
          var salida = moment(this.fecha_salida + ' ' + this.salida);
          if (salida > entrada && entrada.isValid() && salida.isValid()) {

            var send = {
              id: this.cilindro.id,
              serie: this.cilindro.serie,
              codigo: this.cilindro.codigo,
              capacidad: this.cilindro.capacidad, //m3
              propietario: this.cilindro.propietario,
              propietario_id: this.cilindro.propietario_id,
              cantidad: this.cilindro.cantidad, //presion
              ingreso: entrada.format('YYYY-MM-DD HH:mm:ss'),
              retiro: '0',
              registrado: this.cilindro.registrado,
              delete: this.cilindro.delete,
              salida: salida.format('YYYY-MM-DD HH:mm:ss'),
              observacion: this.cilindro.observacion
            };
            if (this.cilindro.marcar_salida) {
              send.retiro = '1';
              var pre_date = moment(this.cilindro.salida_date + ' ' + this.cilindro.salida_time);
              if (pre_date.isValid()) {
                send.salida = this.cilindro.salida_date + ' ' + this.cilindro.salida_time;
              } else {
                success = false;
              }
            }
            if (success) {
              this.cilindros.push(send);
              this.resetCilindro();
            } else {
              toastr.warning('Fecha de salida no válida', 'Revisar');
            }
          } else {
            toastr.warning('Fecha de salida debe ser mayor a la de entrada', 'Revisar');
          }
        } else {
          toastr.warning('Cilindro no seleccionado', 'Revisar');
          this.resetCilindro();
        }
      } else {
        toastr.warning('Cilindro ya fue agregado', 'Error');
        this.resetCilindro();
      }
    },
    fnTargetCilindro: function fnTargetCilindro(e, d) {
      console.log(d);
      this.cilindro.id = d.cil_id;
      this.cilindro.serie = d.serie;
      this.cilindro.codigo = d.codigo;
      this.cilindro.capacidad = d.capacidad;
      this.cilindro.propietario = d.propietario.nombre;
      this.cilindro.propietario_id = d.propietario_id;
      this.cilindro.cantidad = d.presion;
    }
  },
  watch: {
    fecha: function fecha(nv, ov) {
      console.log(nv);
      this.cilindro.salida_date = nv;
      this.fecha_salida = nv;
    },
    salida: function salida(nv, ov) {
      this.cilindro.salida_time = nv;
    },
    sistema: function sistema(nv, ov) {
      // console.log(nv)
      var lote = this.findLote(nv);
      if (lote) {
        this.serie_lote = lote.serie;
        this.numero_lote = lote.actual;
        this.lote_success = true;
      } else {
        this.lote_success = false;
        this.serie_lote = '';
        this.numero_lote = '';
        toastr.error("El sistema no posee lote", "Sistema - Error");
      }
      // if (nv != 0) {

      // }
    }
  },
  computed: {
    total_cilindros: function total_cilindros() {
      return this.cilindros.length;
    },
    total_libras: function total_libras() {
      var sum = 0;
      this.cilindros.forEach(function (v) {

        sum += +v.cantidad;
      });
      return sum;
    }
  },
  created: function created() {
    console.log(this);
    console.log('registro produccion');
    // this.sistema = this.data_sistemas[0].sis_id

    if (this.edit) {
      //cargar cilindros
      // this.cilindros
    }
  },
  mounted: function mounted() {

    // $("#entrada").mask("99:99");
    // $("#salida").mask("99:99");
    var _this = this;
    autosize(document.getElementById('observacion'));
    autosize(document.getElementById('observacion_cilindro'));
    this.cilindro_th = $('#cilindro_th');
    this.cilindro_th.typeahead({
      highlight: true,
      hint: false,
      minLength: 1
    }, {
      async: true,
      name: 'buscar-serie-cilindro',
      display: function display(d) {
        return d.serie;
      },
      source: function source(q, cb, asy) {
        // let result = []
        if (q.trim() != '') {
          var no_buscar = _this.cilindros.map(function (v) {
            return v.id;
          });
          console.log(no_buscar);
          // axios.get(BASE_URL + '/api/cilindro?m=all&q=' + q, {params: {cilindros: no_buscar}}).then(res => {
          axios.get(BASE_URL + '/api/cilindro?m=produccion&q=' + q, { params: { cilindros: no_buscar } }).then(function (res) {
            // console.log(res.data)
            // return res.data
            asy(res.data);
            // return res.data
          });

          // let regex = new RegExp(q, 'i');
          // cb(_this.listaBancos.filter(v => {
          //   return regex.test(v.banco_name)
          // }))
        }
      }
    }).bind('typeahead:select', this.fnTargetCilindro).bind('typeahead:autocomplete', this.fnTargetCilindro);
  }
};

var app_produccion = new Vue({
  el: '#vue_produccion',
  components: {
    registro: registro
    // router
  } });

/***/ })

/******/ });