function togglePassword(id){
    const el=document.getElementById(id);
    if(el) el.type=el.type==="password"?"text":"password";
}
function swapPorts(){
    const inputs=document.querySelectorAll('.search-card input');
    if(inputs.length>=2){ const a=inputs[0].value; inputs[0].value=inputs[1].value; inputs[1].value=a; }
}
function selectSeat(button){
    document.querySelectorAll('.seat.available,.seat.selected').forEach(s=>s.classList.remove('selected'));
    button.classList.add('selected');
    const seat=button.dataset.seat;
    const hidden=document.getElementById('selectedSeat');
    const summary=document.getElementById('summarySeat');
    const btn=document.getElementById('continueSeat');
    if(hidden) hidden.value=seat;
    if(summary) summary.textContent=seat;
    if(btn) btn.disabled=false;
}
document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('.payment-option').forEach(opt=>{
        opt.addEventListener('click',()=>{
            document.querySelectorAll('.payment-option').forEach(x=>x.classList.remove('active'));
            opt.classList.add('active');
            const radio=opt.querySelector('input'); if(radio) radio.checked=true;
        });
    });
});
