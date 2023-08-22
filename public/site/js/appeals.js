$(document).ready(function () {

    if ($("#feedback").length) {
        console.log("Asd");
        var calc = new Vue({
            el: '#feedback',
            delimiters: ['@[[', ']]@'],
            data: {
                selected_code_id: "",
                lock_inputs: false,
                partial_early_repayment_of_the_amount: "",
                date_to_finish: "",
            },
            methods: {
                lockInputs() {
                    this.lock_inputs = !this.lock_inputs
                    console.log(this.partial_early_repayment_of_the_amount)
                },
                printPdf() {
                    axios({})
                    console.log($('meta[name="_token"]').attr('content'));
                    var self = this;

                    axios({
                        url: '/print-pdf',
                        method: 'POST',
                        responseType: 'blob',
                        data: {
                            _token: $('meta[name="_token"]').attr('content'),
                            date_to_finish: self.date_to_finish,
                            partial_early_repayment_of_the_amount: self.partial_early_repayment_of_the_amount,
                        }
                    }).then((response) => {
                        console.log(response)
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'file.pdf');
                        document.body.appendChild(link);
                        link.click();
                    })
                },
            },
            watch: {
                selected_code_id() {
                    console.log("changed", this.selected_code_id)
                }
            }
        });
    }

})
