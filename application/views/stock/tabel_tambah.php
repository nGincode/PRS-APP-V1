
       
               <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                <tr>
                <th style="text-align: center;min-width: 100px;">Tanggal</th>
                <th style="text-align: center;min-width: 100px;">Nama Produk</th>
                <th style="text-align: center;min-width: 90px;">Masuk</th>
                <th style="text-align: center;min-width: 90px;">Sisa</th>
                <th style="text-align: center;min-width: 90px;">Register</th>
                    </tr>

                   <tbody>
                    <tr>
                      
                          <input type="hidden"  name="store_id" value="<?php echo $this->input->post('store_id'); ?>" class="form-control" autocomplete="off"  >

                          <input type="hidden"  name="store_id" value="<?php echo $this->input->post('bagian'); ?>" class="form-control" autocomplete="off"  >

                        <td>
                          <input type="date" required  name="tgl" class="form-control" autocomplete="off"  >
                        </td>
                      
                        <td>
                          <select name="product" class="form-control">
                            <option value="">- Pilih Barang -</option>
                            <?php foreach ($data as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>"><?php echo $v['nama_produk'] ?></option>
                            <?php endforeach ?>
                          </select>
                         
                        </td>
                        <td>
                          <input type="number" required step="any" name="t_unit" class="form-control" autocomplete="off"  >
                        </td>

                        <td>
                          <input type="number" required step="any" name="s_unit" class="form-control" autocomplete="off">
                        </td>
                        
                        <td>
                          <input type="number" step="any"  name="reg" class="form-control" autocomplete="off" required>
                        </td>

                     </tr>
                   </tbody>
                </table>
