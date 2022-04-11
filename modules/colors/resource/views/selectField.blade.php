<?php $name='params[Modules\colors\Models\Color]'; ?>
<color-combobox label="انتخاب رنگ"
                :items="{{ json_encode($colors) }}"
                default="{{ $color_id }}"
                name="{{ $name }}"
>

</color-combobox>
