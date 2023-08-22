$(document).ready(function(){

	if ($("#calculator").length) {

		var calc = new Vue({
			el: '#calculator',
			delimiters: ['@[[',']]@'],
			data: {
				complex : 0,
				initial_fee : 0,
				apartments: [],
				apartment : 0.00,
				apartment_id : 0,
				purchase : [],
				sum : 0,
				cost: 0,
				income : [],
				additional: [],
				tenancy: 5,
				family: 1,
				co_applicants : 0,
				total_income: [],
				total_additional: [],
				obligation : false,
				payment : [],
				result : {},
				confirmation : false
			},

			methods: {

				changeApplicants: function () {
					this.additional = this.additional.slice(0, this.co_applicants + 1);
					this.income = this.income.slice(0, this.co_applicants + 1);
				},

				getApartments : function() {
					var self = this;

					$.ajax({
						url: '/ru/ajax/get-apartments',
						type: 'POST',
						async: false,
						data: {_token: $('meta[name="_token"]').attr('content'), complex_id: self.complex, lang: document.getElementById("lang").value},
						dataType: 'json',
						success: function(data) {
							self.apartments = data;
							self.apartment = self.apartments[0].measure;
							self.apartment_id = self.apartments[0].id;
							console.log(self.apartment);

							self.getApartmentCost();
						}
					});

				},

				getApartmentCost : function() {
					var self = this;

					$.ajax({
						url: '/ru/ajax/get-apartments-cost',
						type: 'POST',
						async: false,
						data: {_token: $('meta[name="_token"]').attr('content'), apartment_id: self.apartment_id},
						dataType: 'json',
						success: function(data) {
							self.costs = data;
							self.cost = self.costs.cost;
							self.apartment = self.costs.measure;
							console.log(self.costs);
						}
					});

				},

				calculate: function() {
					var self = this;

					$.ajax({
						url: '/ru/ajax/calculate',
						type: 'POST',
						async: false,
						data: {_token: $('meta[name="_token"]').attr('content'), complex: self.complex, apartment : self.apartment, initial_fee: self.initial_fee, income : self.income, additional : self.additional, tenancy: self.tenancy, family: self.family, co_applicants: self.co_applicants, payment: self.payment},
						dataType: 'json',
						success: function(data) {
							self.result = data;
						}
					});
				},

				clearData: function() {

					this.complex = $('#complexes option:first-child').val();
					this.getApartments();
					// this.getPurchase();
					this.initial_fee = 0;
					this.sum = 0;
					this.income = [];
					this.additional = [];
					this.tenancy = 5;
					this.family = 1;
					this.co_applicants = 0;
					this.total_income = [];
					this.total_additional = [];
					this.obligation = false;
					this.payment = [];
					this.result = {};
					this.confirmation = false;
				}
			},

			created: function () {
				var e = document.getElementById("complexes");

				this.complex = e.options[e.selectedIndex].value;
			},

			mounted: function () {
				this.$nextTick(function () {

					this.getApartments();

					this.getApartmentCost();

				});
			}
		});
	}

	$('#print_result').click(function() {
		window.print();
	})

});

function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
	    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	    s = '',
	    toFixedFix = function(n, prec) {
	      var k = Math.pow(10, prec);
	      return '' + (Math.round(n * k) / k)
	        .toFixed(prec);
	    };
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
	    .split('.');
	  if (s[0].length > 3) {
	    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	  }
	  if ((s[1] || '')
	    .length < prec) {
	    s[1] = s[1] || '';
	    s[1] += new Array(prec - s[1].length + 1)
	      .join('0');
	  }
	  return s.join(dec);
}
