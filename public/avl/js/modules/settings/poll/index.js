$(document).ready(function () {
	if ($("#poll-instance").length) {
		var poll = new Vue({
			el: '#poll-instance',
			delimiters: ['@[[',']]@'],
			data: {
				sectionId: 0,
				currentLang: 'ru',
				langs: [],
				polls: [],

				pollID: null,
				createOrUpdate: []
			},

			methods: {

				storeOrUpdate: function () {
					var self = this;

					var url  = self.pollID ? '/admin/settings/sections/' + this.sectionId + '/polls/' + self.pollID : '/admin/settings/sections/' + this.sectionId + '/polls';
					var type = self.pollID ? 'PUT' : 'POST';

					$.ajax({
						url: url,
						type: type,
						dataType: 'json',
						data : {
							_token: $('meta[name="_token"]').attr('content'),
							store: self.createOrUpdate
						},
						success: function(data) {
							if (data.success) {
								messageSuccess(data.success);
							}

							self.getPolls();
							self.clear();
						}
					});
				},

				getForUpdate: function (id, e) {
					var self = this;
					$.ajax({
						url: '/admin/settings/sections/' + self.sectionId + '/polls/' + id,
						type: 'GET',
						dataType: 'json',
						data : { },
						success: function(data) {
							self.pollID = id;
							self.createOrUpdate = data;
						}
					});
				},

				getPolls: function () {
					var self = this;

					$.ajax({
						// url: '/admin/settings/sections/' + this.sectionId + '/polls',
						url: '/admin/settings/sections/' + this.sectionId + '/polls/get-records',
						type: 'GET',
						dataType: 'json',
						data : {
							_token: $('meta[name="_token"]').attr('content')
						},
						success: function(data) {
							self.polls = data;
						}
					});
				},

				getLangs: function () {
					var self = this;

					$.ajax({
						url: '/api/get-langs',
						type: 'POST',
						dataType: 'json',
						data : {
							_token: $('meta[name="_token"]').attr('content')
						},
						success: function(data) {
							self.langs = data;
							self.clear();
						}
					});
				},

				clear: function () {
					var self = this;

					var $titles = {};
					$.each(self.langs, function (key, lang) {
						$titles['title_' + lang.key] = '';
					});
					self.createOrUpdate = $titles;
					self.pollID = null;
				},

				removePoll: function (id) {
					var $confirm = confirm('Вы действительно желаете удалть данный опрос и все его вопросы и ответы?');

					if ($confirm) {
						var self = this;

						$.ajax({
							url: '/admin/settings/sections/' + self.sectionId + '/polls/' + id,
							type: 'DELETE',
							dataType: 'json',
							async: false,
							data : { _token: $('meta[name="_token"]').attr('content') },
							success: function(data) {
								if (data.success) {
									messageSuccess(data.success);
									self.getPolls();
								}
								if (data.errors) {
									messageError(data.errors);
								}

							}
						});
					}

				},
			},

			mounted: function () {

				var self = this;
				this.$nextTick(function () {
					self.getLangs();

					self.sectionId = $("#section--id").val();

					self.getPolls();
				});
			},

			updated: function () {
				//
			}

		});
	}
});
