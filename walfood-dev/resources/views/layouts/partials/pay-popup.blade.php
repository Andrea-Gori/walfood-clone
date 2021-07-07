<div class="pay-popup d-flex justify-content-center align-items-center "
     v-if="msgTransaction">
    <div v-if="!pagamentoOk" class="message d-flex justify-content-center align-items-center flex-column">
        <h1>Pagamento in corso...</h1>
        <i class="fas fa-spinner"></i>
    </div>
    <div v-if="pagamentoOk && !pagamentoError"
         class="message-ok d-flex justify-content-center align-items-center flex-column">
        <h1>Pagamento accettato!</h1>
        <p>Controlla la mail per i dettagli</p>
        <i class="fas fa-check"></i>
    </div>
    <div v-if="pagamentoError" class="message-error d-flex justify-content-center align-items-center flex-column">
        <h1>Pagamento rifiutato!</h1>
        <p>Controlla i dati del pagamento e riprova</p>
        <p>@{{ msgErroreBrainTree }}</p>
        <i class="fas fa-times"></i>
    </div>
</div>
