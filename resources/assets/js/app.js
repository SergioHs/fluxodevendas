$(document).ready(function(){

    $("#select-estados").on('change', function(ev){
        if(this.value){
            var id = this.value;
            fetch('/public/cidades/por-estado/'+id, function(data){console.log(data)});
        }
    });

});

function ArgumentException(message){
    this.name = "Argument Exception";
    this.message = message;
}

function fetch(url, success, error, complete){
    var endpoint;
    if(url.indexOf("http") === 0){
        endpoint = url
    } else {
        var protocol = window.location.protocol;
        var separator = '//';
        var currentHost = window.location.hostname;
        endpoint = protocol+separator+currentHost;
    }

    if(success && typeof success != "function")
        throw new ArgumentException("Argument 'exception' must be a function");

    if(error && typeof  error != "function")
        throw new ArgumentException("Argument 'error' must be a function");

    if(complete && typeof  error != "function")
        throw new ArgumentException("Argument 'error' must be a function");

    $.get({
        url: endpoint,
        success: success || undefined,
        error: error || undefined,
        complete: complete || undefined
    })
}

