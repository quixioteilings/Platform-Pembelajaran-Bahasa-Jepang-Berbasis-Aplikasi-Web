# Aturan Pengembangan & Git Workflow Proyek

Setiap kali pengguna meminta perbaikan (*fix*) atau penambahan fitur baru (*feature*):
1. **Wajib Buat Branch Baru**: Buat branch terpisah sesuai konteks tugas (misal: `fix/<nama-fitur>` untuk perbaikan bug atau `feat/<nama-fitur>` untuk fitur baru).
2. **Implementasi & Pengujian**: Kerjakan perubahan kode dengan rapi dan pastikan tidak ada error.
3. **Commit & Langsung Push**: Selalu commit perubahan dengan pesan yang jelas, lalu **langsung push** ke remote repository GitHub (`git push -u origin <nama-branch>`).
4. **Berikan Link Pull Request**: Berikan tautan langsung untuk membuat Pull Request di GitHub agar memudahkan review dan merge.

