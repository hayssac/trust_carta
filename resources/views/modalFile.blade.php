<div class="modal" tabindex="-1" role="dialog" id="fileModal" aria-labelledby="modalFile" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Inserir certificado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form class="form-horizontal" action="{{ route('certificado.login') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            
            <div class="modal-body">
                <input name="certificado" placeholder="" class="form-control" type="file" >
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
  </div>
</div>