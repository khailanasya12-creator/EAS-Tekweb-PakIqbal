public function up()
{
    Schema::table('items', function (Blueprint $table) {
        $table->string('kategori')->nullable(); // Menambahkan kolom kategori
    });
}

public function down()
{
    Schema::table('items', function (Blueprint $table) {
        $table->dropColumn('kategori');
    });
}
