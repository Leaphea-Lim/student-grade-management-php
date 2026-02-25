<footer class="main-footer">
    © StudentTracker <span/> RUPP Project
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (isset($_GET['msg'])): ?>
<script>
    const toastEl = document.getElementById('successToast');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
    }
</script>
<?php endif; ?>

</body>
<script>
    function toggleMenu() {
        const menu = document.getElementById('nav-menu');
        const icon = document.getElementById('menu-icon');
        menu.classList.toggle('open');
        icon.className = menu.classList.contains('open')
            ? 'bi bi-x'
            : 'bi bi-list';
        icon.style.fontSize = '1.5rem';
        icon.style.color = 'white';
    }
</script>
</html>