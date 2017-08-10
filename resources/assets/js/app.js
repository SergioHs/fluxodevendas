$(document).ready(function(){

    $("#select-estados").on('change', function(ev){
        if(this.value){
            var id = this.value;
            fetch('/cidades/por-estado/'+id,
                function(data){
                    var selectCidades = $("#select-cidades");
                    selectCidades.empty();
                    $.each(data, function(a,e,i){
                        selectCidades.append("<option value='"+e.id+"'>" + e.cidade + "</option>");
                    });
                }
            );
        }
    });
});

function ArgumentException(message){
    this.name = "Argument Exception";
    this.message = message;
}

function fetch(url, success, error, complete){
    var baseUrl;
    if(url.indexOf("http") === 0){
        baseUrl = url
    } else {
        var protocol = window.location.protocol;
        var separator = '//';
        var currentHost = window.location.hostname;
        baseUrl = protocol+separator+currentHost;
        if(url.indexOf("/") !== 0)
            baseUrl += "/";

        baseUrl += url;
    }

    if(success && typeof success != "function")
        throw new ArgumentException("Argument 'exception' must be a function");

    if(error && typeof  error != "function")
        throw new ArgumentException("Argument 'error' must be a function");

    if(complete && typeof  error != "function")
        throw new ArgumentException("Argument 'complete' must be a function");

    $.get({
        url: baseUrl,
        success: success || undefined,
        error: error || undefined,
        complete: complete || undefined
    });
}

$('table.ajax-modal-table').on('click', 'tr', function(ev){
    //this eh tr
    var $entityId = $(this).attr('data-entity-id');
    var $route = $(ev.delegateTarget).attr('data-route');
    var $modal = $(ev.delegateTarget).attr('data-modal');

    fetch($route + "/" + $entityId,
        function(data){
            $($modal).html(data).foundation('open');
        });
});

$('#venda-detail-modal').on('change', "#etapas-container input[type='checkbox']", function(ev){
   $(this).next('label').toggleClass('has-line-through');
   var vendaId = $("#input-venda-id").val();
    fetch('/venda/'+vendaId+"/mudar-status-subetapa/"+$(this).val(),
        function(){
            alert("Etapa atualizada");
    })
});

$('#venda-detail-modal').on('click', 'button#concluir-etapa', function(ev){
    var vendaId = $("#input-venda-id").val();

    fetch('/venda/'+vendaId+'/concluir-etapa-em-andamento',
        function(){
            fetch('/venda/detail/'+vendaId,
                function(data){
                    $("#venda-detail-modal").html(data).foundation('open');
                });
        });


});