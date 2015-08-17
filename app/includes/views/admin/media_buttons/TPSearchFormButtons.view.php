<div id="constructorSearchFormModal" title="<?php _e('Constructor search form', KPDPlUGIN_TEXTDOMAIN ); ?>" style="display: none;">
    <table>
        <tr>
            <td id="td_select_search_form">
                <?php if(!empty($this->data)){ ?>
                    <?php if(count($this->data)>1){ ?>
                        <select name="select_search_form" id="select_search_form">
                            <?php foreach($this->data as $key => $record): ?>
                                <option value="<?php echo $record['id'];?>"
                                    <?php echo selected($key, 0); ?>>
                                    <?php echo $record['title'];?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php }else{ ?>
                        <label>
                        <?php foreach($this->data as $key => $record): ?>
                            <?php echo $record['title'];  ?>
                            <input type="hidden" name="select_search_form"
                                   id="select_search_form" value="<?php echo $record['id'];?>">
                        <?php endforeach; ?>
                        </label>
                    <?php } ?>
                <?php } else{ _e("No customized search form", KPDPlUGIN_TEXTDOMAIN); } ?>
            </td>
        </tr>
        <tr id="tr_origin_search_form">
            <td>
                <input type="text" name="origin_search_form" id="origin_search_form" value=""
                       class="constructorCityShortcodesAutocomplete regular-text code"
                       placeholder="<?php _e('City of departure default', KPDPlUGIN_TEXTDOMAIN) ?>">
            </td>
        </tr>
        <tr id="tr_destination_search_form">
            <td>
                <input type="text" name="destination_search_form" id="destination_search_form" value=""
                       class="constructorCityShortcodesAutocomplete regular-text code"
                       placeholder="<?php _e('City Arrival default', KPDPlUGIN_TEXTDOMAIN) ?>">
            </td>
        </tr>
    </table>
</div>