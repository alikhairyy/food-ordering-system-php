<?php // app/views/partials/footer.php ?>
<script>
// Generic modal helpers
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
// Close on overlay click
document.querySelectorAll('.modal-overlay').forEach(function(el){
    el.addEventListener('click', function(e){ if(e.target===el) el.classList.remove('open'); });
});
</script>
</body>
</html>
