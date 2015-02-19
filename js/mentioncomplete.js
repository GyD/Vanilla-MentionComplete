$(document).ready(function(){
        
    $('#Form_Comment #Form_Body').textcomplete([{ // html
        cache: true,
        match: /\B@(\w{2,})$/,
        search: function(term, callback){
            $.get(gdn.url('/dashboard/user/autocomplete/'), {
                    'q': term,
                    'limit': 10,
                    'timestamp': +new Date()
                },
                function(data){
                    results = data.split(/\|[0-9]+\n/).filter(function(n){ return n != "" });
                    callback(results);
                }
            );
        },
        index: 1,
        replace: function(mention){
            return '@' + mention + ' ';
        }
    }]);
});