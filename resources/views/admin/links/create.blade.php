<!-- Modal Criar Link -->
<div class="modal fade" id="createLinkModal" tabindex="-1" aria-labelledby="createLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- tamanho grande -->
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="createLinkModalLabel">Novo Link</h5>
            </div>

            <form action="{{ route('shorten') }}" method="POST" id="createLinkForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Destination URL -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Destination URL
                                    <i class="fa fa-question-circle text-success ms-1" data-bs-toggle="tooltip"
                                        title="Informe o endereço completo que deseja encurtar, começando com http ou https."></i>
                                </label>
                                <input type="url" name="url" id="url" class="form-control" placeholder="https://..." required>
                            </div>

                            <!-- Short Link -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Short Link
                                    <i class="fa fa-question-circle text-success ms-1" data-bs-toggle="tooltip"
                                        title="Defina o código curto que será usado após o domínio. Exemplo: meudominio.com/promo123"></i>
                                </label>
                                <div class="input-group">
                                    <span id="domain" class="input-group-text">{{ $company->domain ?? 'meudominio.com' }}/</span>
                                    <input type="text" name="short_code" class="form-control" id="short_code" placeholder="ex: promo123" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Senha (opcional)
                                    <i class="fa fa-question-circle text-success ms-1" data-bs-toggle="tooltip"
                                        title="Defina uma senha para proteger este link. Somente quem souber a senha poderá acessá-lo."></i>
                                </label>
                                <input type="text" id="pa" name="password" class="form-control" placeholder="Digite uma senha">
                            </div>

                            <!-- Expiração -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Data de Expiração
                                    <i class="fa fa-question-circle text-success ms-1" data-bs-toggle="tooltip"
                                        title="Defina até quando este link será válido. Após essa data ele deixará de funcionar."></i>
                                </label>
                                <input type="date" name="expire_at" id="expire_at" class="form-control">
                            </div>

                            <!-- Tags -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Tags
                                    <i class="fa fa-question-circle text-success ms-1" data-bs-toggle="tooltip"
                                        title="Adicione categorias ou palavras-chave para organizar melhor seus links."></i>
                                </label>
                                <select id="tags" name="tags[]" multiple placeholder="Selecione ou crie tags...">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Comments -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Comentários
                                    <i class="fa fa-question-circle text-success ms-1" data-bs-toggle="tooltip"
                                        title="Use este campo para anotações internas sobre o link. Não aparece para os visitantes."></i>
                                </label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <small class="text-muted d-block mb-2">QR Code</small>

                                    <div class="qr-box d-flex align-items-center justify-content-center border rounded bg-light mb-3">
                                        <div id="qrCodePreview" class="text-muted">[ Preview QR ]</div>
                                    </div>

                                    <div class="d-flex gap-2 justify-content-center">
                                        <button id="downloadQr" class="btn btn-sm btn-success">Download</button>
                                        <button id="copyQr" class="btn btn-sm btn-outline-primary">Copiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Criar Link</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
