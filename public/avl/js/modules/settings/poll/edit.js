$(document).ready(function () {
	if ($("#poll-instance").length) {
		var poll = new Vue({
			el: '#poll-instance',
			delimiters: ['@[[',']]@'],
			data: {
				sectionId: 0,
				pollID: null,

				currentLang: 'ru',
				langs: [],

				questions: {
					showAnswer: null,
					current: null,
					records: [],
					createOrUpdate: []
				},

				answers: {
					current: null,
					records: [],
					createOrUpdate: []
				}
			},

			methods: {

				getQuestionForUpdate: function (id, e) {
					this.questions.current = id;
					this.questions.showAnswer = null;

					this.answers.records = [];
					var self = this;
					$.ajax({
						url: '/admin/settings/sections/' + self.sectionId + '/polls/' + id,
						type: 'GET',
						dataType: 'json',
						data : { },
						success: function(data) {
							self.questions.createOrUpdate = data;
						}
					});
				},

				getAnswerForUpdate: function (id, e) {
					this.answers.current = id;
					var self = this;
					$.ajax({
						url: '/admin/settings/sections/' + self.sectionId + '/polls/' + id,
						type: 'GET',
						dataType: 'json',
						data : { },
						success: function(data) {
							self.answers.createOrUpdate = data;
						}
					});
				},

				storeOrUpdateQuestion: function (id) {
					var self = this;
					var url  = id ? '/' + id : '';
					var type = id ? 'PUT' : 'POST';

					$.ajax({
						url: '/admin/settings/sections/' + this.sectionId + '/polls' + url,
						type: type,
						dataType: 'json',
						data : {
							_token: $('meta[name="_token"]').attr('content'),
							store: self.questions.createOrUpdate,
							parent_id: self.pollID
						},
						success: function(data) {
							if (data.success) {
								messageSuccess(data.success);
							}

							self.questions.records = self.getRecords(self.pollID);
							self.clearQuestions();
						}
					});
				},

				storeOrUpdateAnswer: function (id) {
					var self = this;
					var url  = id ? '/' + id : '';
					var type = id ? 'PUT' : 'POST';

					$.ajax({
						url: '/admin/settings/sections/' + this.sectionId + '/polls' + url,
						type: type,
						dataType: 'json',
						data : {
							_token: $('meta[name="_token"]').attr('content'),
							store: self.answers.createOrUpdate,
							parent_id: self.questions.showAnswer
						},
						success: function(data) {
							if (data.success) {
								messageSuccess(data.success);
							}

							self.answers.records = self.getRecords(self.questions.showAnswer);
							self.clearAnswers();
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
						}
					});
				},

				getRecords: function (id) {
					var self = this;
					var $records = {};

					$.ajax({
						url: '/admin/settings/sections/' + self.sectionId + '/polls/get-records/' + id,
						type: 'GET',
						dataType: 'json',
						async: false,
						data : { },
						success: function(data) {
							$records = data;
						}
					});

					return $records;
				},

				clearQuestions: function () {
					var self = this;

					var $titles = {};
					$.each(self.langs, function (key, lang) {
						$titles['title_' + lang.key] = '';
					});
					self.questions.createOrUpdate = $titles;
					self.questions.current = null;
					self.questions.showAnswer = null;
					self.answers.records = [];
				},

				clearAnswers: function () {
					var self = this;

					var $titles = {};
					$.each(self.langs, function (key, lang) {
						$titles['title_' + lang.key] = '';
					});
					self.answers.createOrUpdate = $titles;
					self.answers.current = null;
				},

				getAnswers: function (id, e) {
					this.answers.records = this.getRecords(id);
					this.questions.showAnswer = id;
					this.questions.current = null;

					var $titles = {};
					$.each(this.langs, function (key, lang) {
						$titles['title_' + lang.key] = '';
					});
					this.questions.createOrUpdate = $titles;

				},

				removeQuestion: function (id) {
					var $confirm = confirm('Вы действительно желаете удалть данный вопрос и все его ответы?');

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
									self.questions.records = self.getRecords(self.pollID);
									self.clearQuestions();
									self.clearAnswers();
								}
								if (data.errors) {
									messageError(data.errors);
								}

							}
						});
					}
				},

				removeAnswer: function (id) {
					var $confirm = confirm('Вы действительно желаете удалть данный ответ и все его результаты?');

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
									self.answers.records = self.getRecords(self.questions.showAnswer);
									self.clearAnswers();
								}
								if (data.errors) {
									messageError(data.errors);
								}
							}
						});
					}
				}
			},

			mounted: function () {

				var self = this;
				this.$nextTick(function () {
					self.getLangs();

					self.sectionId = $("#section--id").val();
					self.pollID = $("#poll--id").val();

					// список вопросов к опросу
					this.questions.records = self.getRecords(self.pollID);

					this.clearQuestions();
					this.clearAnswers();

				});
			},

			updated: function () {
				//
			}

		});
	}
});
