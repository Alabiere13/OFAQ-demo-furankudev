var callAjax = {

    init: function() {

        $('.toggleQuestionVote').on('click', callAjax.toggleVote )

    },

    toggleVote: function(evt) {
        console.log(toggleVoteApi);
        $.ajax(
            {
                url: toggleVoteApi, 
                type: 'POST',
                data:{
                }
            }
        ).done(
            function(value){
                console.log('API OK : ' + value)
                var addVote = '<button type="submit" class="btn btn-info d-inline toggleQuestionVote"><i class="fas fa-heart"></i></i>&nbsp;Donner son vote</button>';
                var removeVote = '<button type="submit" class="btn btn-warning d-inline toggleQuestionVote"><i class="fas fa-heart-broken"></i>&nbsp;Retirer son vote</button>';
                if (value) {
                    $(evt.target).replaceWith(removeVote);
                } else {
                    $(evt.target).replaceWith(addVote);
                }
            }
        )
    }
}

$(callAjax.init());
