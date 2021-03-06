let url, pelanggan = $("#pelanggan").DataTable({
    responsive: true,
    scrollX: true,
    ajax: readUrl,
    columnDefs: [{
        searcable: false,
        orderable: false,
        targets: 0
    }],
    order: [
        [1, "asc"]
    ],
    columns: [{
        data: null
    }, {
        data: "nama"
    }, {
        data: "alamat"
    }, {
        data: "telepon"
    }, {
        data: "tipe"
    }, {
        data: "action"
    }]
});

function reloadTable() {
    pelanggan.ajax.reload()
}

function addData() {
    $.ajax({
        url: addUrl,
        type: "post",
        dataType: "json",
        data: $("#form").serialize(),
        success: () => {
            $(".modal").modal("hide");
            Swal.fire("Sukses", "Sukses Menambahkan Data", "success");
            reloadTable()
        },
        error: err => {
            console.log(err)
        }
    })
}

function remove(id) {
    Swal.fire({
        title: "Hapus",
        text: "Hapus data ini?",
        type: "warning",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: `Yes`,
        denyButtonText: `No`,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: deleteUrl,
                type: "post",
                dataType: "json",
                data: {
                    id: id
                },
                success: a => {
                    Swal.fire("Sukses", "Sukses Menghapus Data", "success");
                    reloadTable()
                },
                error: a => {
                    console.log(a)
                }
            })
        }
    })
}

function editData() {
    $.ajax({
        url: editUrl,
        type: "post",
        dataType: "json",
        data: $("#form").serialize(),
        success: () => {
            $(".modal").modal("hide");
            Swal.fire("Sukses", "Sukses Mengedit Data", "success");
            reloadTable()
        },
        error: err => {
            console.log(err)
        }
    })
}

function add() {
    url = "add";
    $(".modal-title").html("Add Data");
    $('.modal button[type="submit"]').html("Add")
    $('#tipe').val("").trigger('change');
}

function edit(id) {
    $('#tipe').val("").trigger('change');
    $.ajax({
        url: get_pelangganUrl+"?id="+id,
        type: "get",
        dataType: "json",
        success: res => {
            $('[name="id"]').val(res.id);
            $('[name="nama"]').val(res.nama);
            $('[name="alamat"]').val(res.alamat);
            $('[name="telepon"]').val(res.telepon);
            $('[name="tipe"]').append(`<option value='${res.tipe_id}'>${res.tipe}</option>`);
            $('#tipe').val(res.tipe_id).trigger('change');
            $(".modal").modal("show");
            $(".modal-title").html("Edit Data");
            $('.modal button[type="submit"]').html("Edit");
            url = "edit"
        },
        error: err => {
            console.log(err)
        }
    })
}
pelanggan.on("order.dt search.dt", () => {
    pelanggan.column(0, {
        search: "applied",
        order: "applied"
    }).nodes().each((el, val) => {
        el.innerHTML = val + 1
    })
});
$("#form").validate({
    errorElement: "span",
    errorPlacement: (err, ell) => {
        err.addClass("invalid-feedback");
        ell.closest(".form-group").append(err)
    },
    submitHandler: () => {
        "edit" == url ? editData() : addData()
    }
});
$(".modal").on("hidden.bs.modal", () => {
    $("#form")[0].reset();
    $("#form").validate().resetForm()
});

$("#tipe").select2({
    placeholder: "Tipe",
    // minimumResultsForSearch: Infinity,
    ajax: {
        url: tipeUrl,
        type: "post",
        dataType: "json",
        processResults: data => ({
            results: data
        }),
        cache: true
    }
});