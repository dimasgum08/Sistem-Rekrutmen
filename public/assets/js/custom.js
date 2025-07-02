
window.addEventListener('load', () => {
    document.getElementById('page-loader').classList.add('hidden');
});

$(function () {
    $('.toggle-password').on('click', function () {
        let $input = $(this).siblings('input');
        let $icon = $(this).find('i');

        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('ti ti-eye').addClass('ti ti-eye-off');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('ti ti-eye-off').addClass('ti ti-eye');
        }
    });

    $('button[type="submit"]').on('click', function () {
        $(this).html('<i class="ti ti-loader ti-spin font-size-16 align-middle me-2"></i>Loading...');
        $(this).prop('disabled', true);
        $(this).closest('form').submit();
    });

    $('.numeric').on('input', function () {
        let val = $(this).val().replace(/[^0-9]/g, ''); // hanya angka
        val = val === '' ? '' : Math.min(parseInt(val), 100); // max 100
        $(this).val(val);
    });

    if ($('meta[name="permissions"]').attr('content') !== undefined) {
        window.permissions = $('meta[name="permissions"]').attr('content').split(',');
    }

    if ($('meta[name="roles"]').attr('content') !== undefined) {
        window.roles = $('meta[name="roles"]').attr('content').split(',');
    }

    $('.choices-js').each(function () {
        if (!this.choicesInstance) {
            const enableSearch = $(this).data('search') !== undefined;
            this.choicesInstance = new Choices(this, {
                removeItemButton: true,
                searchEnabled: enableSearch,
                placeholderValue: 'Pilih opsi',
                noResultsText: 'Tidak ditemukan',
                shouldSort: false
            });
        }
    });

   $('.flatpickr').each(function () {
        if (!this._flatpickr) {
            const isRange = $(this).data('range') !== undefined;
            const currentValue = $(this).val();
            flatpickr(this, {
                dateFormat: "Y-m-d",
                allowInput: true,
                mode: isRange ? "range" : "single",
                defaultDate: currentValue ? currentValue : null,
            });
        }
    });

    $('.flatpickr-datetime').flatpickr({
        enableTime: true,
        allowInput: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        // defaultDate: new Date(),
        minuteIncrement: 1,
        allowInput: true
    });

    $('.ckeditor').each(function () {
        if (!this.ckeditorInstance) {
            ClassicEditor
            .create(this, {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', 'undo', 'redo'
                ],
                language: 'en',
            })
            .then(editor => {
                this.ckeditorInstance = editor;
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '200px', editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error(error);
            });
        }
    });

});

// filepond
FilePond.registerPlugin(FilePondPluginImagePreview);
document.querySelectorAll(".filepond").forEach((inputElement) => {
    FilePond.create(inputElement, {
        storeAsFile: true,
    });
});



function confirmDelete(opt) {
  Swal.fire({
      title: opt.title || "Are you sure?",
      text: opt.message || "You won't be able to revert this!",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#08428C",
      cancelButtonColor: "#6e7881",
      confirmButtonText: opt.confirmButtontext || "Yes, delete it!"
  }).then((result) => {
      if (result.isConfirmed) {
          fetch(opt.url, {
              method: "DELETE",
              headers: opt.headers || {}
          })
          .then(response => response.json())
          .then(data => {
            Swal.fire({
                title: "Berhasil!",
                text: data.message || "Data berhasil dihapus.",
                icon: "success",
                timer: 2000
            });

            if (typeof __initDataTable !== 'undefined' && __initDataTable !== null) {
              __initDataTable.ajax.reload();
          }
        })
        .catch(error => {
            Swal.fire({
                title: "Error!",
                text: error.message || "Terjadi kesalahan saat menghapus data.",
                icon: "error"
            });
        });
      }
  });
}

function strip_tags(input) {
    const tempDiv = document.createElement("div");
    tempDiv.innerHTML = input;
    return tempDiv.textContent || tempDiv.innerText || "";
}

function limitText(text, limit = 100) {
    return text.length > limit ? text.substring(0, limit) + "..." : text;
}

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

$('.modal').on('hidden.bs.modal', function () {
    const $form = $(this).find('form');

    $form.each(function () {
        const token = $(this).find('input[name="_token"]').val();
        this.reset();
        $(this).find('input[name="_token"]').val(token);
    });

    $(this).find(`
        input:not([name="_token"]):not([type="file"]),
        input[type="email"],
        input[type="text"],
        input[type="number"],
        input[type="url"],
        input[type="tel"],
        input[type="hidden"]:not([name="_token"]),
        input[type="password"],
        input[type="datetime-local"],
        input[type="time"],
        input[type="date"],
        textarea,
    `).val(null).trigger('change');
    $(this).find('input[type="file"]').val(null);
    $(this).find('input[type="radio"], input[type="checkbox"]').prop('checked', false);
    $(this).find('.filepond').each(function () {
        FilePond.find(this).removeFiles();
    });
});


