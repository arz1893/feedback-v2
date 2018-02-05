if($('#vue_question_container').length > 0) {
    var vue_question = new Vue({
        el: '#vue_question_container',
        data: {
            is_edited: false,
            default_text: ''
        },
        methods: {
            editQuestion: function (event) {
                this.is_edited = !this.is_edited;
                this.default_text = $('#answer_content').text();
                if(this.is_edited === true) {
                    $('#box_edit_answer').removeAttr('style');
                } else if(this.is_edited === false) {
                    $('#box_edit_answer').attr('style', 'display: none;');
                }
            }
        }
    });
}