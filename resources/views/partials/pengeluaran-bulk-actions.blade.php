<form method="POST" action="{{ route('pengeluaran.bulkActions') }}" id="bulkForm">
    @csrf

    <div class="input-group">
    
        <select name="action" class="form-control" required>
            <option value="">Bulk Actions</option>

            @if($status === 'Deleted')
                <option value="restore">Restore</option>
                <option value="force_delete">Hapus Permanen</option>
            @else
                <option value="delete">Delete</option>
            @endif
        </select>

        <span class="input-group-btn">
            <button type="button" id="bulkGo" class="btn btn-primary">Go</button>
        </span>
    </div>
</form>




<script>
document.getElementById('bulkGo').addEventListener('click', function() {

    let selected = $('#PengeluaranTable').bootstrapTable('getSelections');

    if (selected.length === 0) {
        alert('Tidak ada data dipilih');
        return;
    }

    let form = this.closest('form');

    // Hapus hidden input ids sebelumnya jika ada
    form.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());

    // Tambahkan hidden input ids[] berdasarkan pilihan
    selected.forEach(function(row) {
        let hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'ids[]';

        // Id pasti ada di row.id (BootstrapTable default)
        hidden.value = row.id;

        form.appendChild(hidden);
    });

    form.submit();
});
</script>