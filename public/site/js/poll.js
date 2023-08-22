$(function () {
	if ($("#poll-instance").length) {
		var poll = new Vue({
			el: '#poll-instance',
			delimiters: ['@[[',']]@'],
			data: {
				pollId: null,
				questions: [],
				currentVote: null
			},

			methods: {
				setVote: function () {
					var self = this;

					$.ajax({
						url: $("#poll-instance-path").val(),
						type: 'POST',
						dataType: 'json',
						data : {
							_token: $('meta[name="_token"]').attr('content'),
							poll: self.pollId,
							answer: self.currentVote
						},
						success: function(data) {
							self.getQuestions();
						}
					});
				},

				getQuestions: function () {
					var self = this;

					$.ajax({
						url: $("#poll-instance-path").val(),
						type: 'GET',
						dataType: 'json',
						data : { poll: self.pollId },
						success: function(data) {
							self.questions = data;
						}
					});
				}
			},

			mounted: function () {
				var self = this;

				this.$nextTick(function () {
					$("#poll-instance").fadeIn();

					self.pollId = $('#poll-instance-poll--id').val();
					self.getQuestions();
				});
			}
		});

	}
});
