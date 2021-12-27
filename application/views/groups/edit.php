<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Groups</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url('groups/') ?>">Groups</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box box-danger box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b> Edit Grup</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <form role="form" action="<?php base_url('groups/update') ?>" method="post">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="group_name">Nama Group</label>
                <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter group name" value="<?php echo $group_data['group_name']; ?>">
              </div>
              <div class="form-group">
                <label for="permission">Perizinan</label>

                <?php $serialize_permission = unserialize($group_data['permission']); ?>

                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Tambah</th>
                      <th>Edit</th>
                      <th>lihat</th>
                      <th>Hapus</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Leader Outlet</td>
                      <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createUser" <?php if ($serialize_permission) {
                                                                                                                                          if (in_array('createUser', $serialize_permission)) {
                                                                                                                                            echo "checked";
                                                                                                                                          }
                                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUser" <?php
                                                                                                                        if ($serialize_permission) {
                                                                                                                          if (in_array('updateUser', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        }
                                                                                                                        ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUser" <?php
                                                                                                                      if ($serialize_permission) {
                                                                                                                        if (in_array('viewUser', $serialize_permission)) {
                                                                                                                          echo "checked";
                                                                                                                        }
                                                                                                                      }
                                                                                                                      ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUser" <?php
                                                                                                                        if ($serialize_permission) {
                                                                                                                          if (in_array('deleteUser', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        }
                                                                                                                        ?>></td>
                    </tr>
                    <tr>
                      <td>Groups</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createGroup" <?php
                                                                                                                          if ($serialize_permission) {
                                                                                                                            if (in_array('createGroup', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          }
                                                                                                                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateGroup" <?php
                                                                                                                          if ($serialize_permission) {
                                                                                                                            if (in_array('updateGroup', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          }
                                                                                                                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewGroup" <?php
                                                                                                                        if ($serialize_permission) {
                                                                                                                          if (in_array('viewGroup', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        }
                                                                                                                        ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteGroup" <?php
                                                                                                                          if ($serialize_permission) {
                                                                                                                            if (in_array('deleteGroup', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          }
                                                                                                                          ?>></td>
                    </tr>
                    <tr>
                      <td>Brands Product</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createBrand" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('createBrand', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateBrand" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('updateBrand', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewBrand" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('viewBrand', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteBrand" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('deleteBrand', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                    </tr>
                    <tr>
                      <td>Kategori</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCategory" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('createCategory', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCategory" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updateCategory', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCategory" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewCategory', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCategory" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('deleteCategory', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                    </tr>
                    <tr>
                      <td>Outlet</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createStore" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('createStore', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateStore" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('updateStore', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewStore" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('viewStore', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteStore" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('deleteStore', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                    </tr>
                    <tr>
                      <td>Attributes</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createAttribute" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('createAttribute', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateAttribute" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('updateAttribute', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewAttribute" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('viewAttribute', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteAttribute" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('deleteAttribute', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                    </tr>



                    <tr>
                      <td>Pengadaan</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createpengadaan" class="minimal" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('createpengadaan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatepengadaan" class="minimal" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('updatepengadaan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewpengadaan" class="minimal" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('viewpengadaan', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletepengadaan" class="minimal" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('deletepengadaan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                    </tr>

                    <tr>
                      <td>Inventaris</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createivn" class="minimal" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('createivn', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateivn" class="minimal" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('updateivn', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewivn" class="minimal" <?php if ($serialize_permission) {
                                                                                                                        if (in_array('viewivn', $serialize_permission)) {
                                                                                                                          echo "checked";
                                                                                                                        }
                                                                                                                      } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteivn" class="minimal" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('deleteivn', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                    </tr>

                    <tr>
                      <td>Stock</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createstock" class="minimal" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('createstock', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatestock" class="minimal" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('updatestock', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewstock" class="minimal" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('viewstock', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletestock" class="minimal" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('deletestock', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                    </tr>




                    <tr>
                      <td>Barang</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createProduct" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('createProduct', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProduct" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updateProduct', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProduct" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewProduct', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteProduct" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('deleteProduct', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                    </tr>
                    <tr>
                      <td>Orders</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createOrder" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('createOrder', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrder" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('updateOrder', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewOrder" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('viewOrder', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteOrder" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('deleteOrder', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                    </tr>

                    <tr>
                      <td>Pegawai</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createPegawai" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('createPegawai', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatePegawai" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updatePegawai', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewPegawai" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewPegawai', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletePegawai" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('deletePegawai', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                    </tr>

                    <tr>
                      <td>Omzet</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createOmzet" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('createOmzet', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOmzet" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('updateOmzet', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewOmzet" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('viewOmzet', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteOmzet" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('deleteOmzet', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                    </tr>
                    <tr>
                      <td>Absensi Office</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createabsen" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('createabsen', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateabsen" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('updateabsen', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewabsen" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('viewabsen', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteabsen" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('deleteabsen', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                    </tr>


                    <tr>
                      <td>Pelaporan</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createpelaporan" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('createpelaporan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatepelaporan" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('updatepelaporan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewpelaporan" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('viewpelaporan', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletepelaporan" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('deletepelaporan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                    </tr>


                    <tr>
                      <td>Belanja</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createbelanja" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('createbelanja', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatebelanja" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updatebelanja', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewbelanja" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewbelanja', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletebelanja" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('deletebelanja', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                    </tr>

                    <tr>
                      <td>Voucher Pegawai</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createvocp" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('createvocp', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatevocp" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('updatevocp', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewvocp" <?php if ($serialize_permission) {
                                                                                                                        if (in_array('viewvocp', $serialize_permission)) {
                                                                                                                          echo "checked";
                                                                                                                        }
                                                                                                                      } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletevocp" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('deletevocp', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                    </tr>


                    <tr>
                      <td>Point Of Sales (POS)</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createpos" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('createpos', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatepos" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('updatepos', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewpos" <?php if ($serialize_permission) {
                                                                                                                        if (in_array('viewpos', $serialize_permission)) {
                                                                                                                          echo "checked";
                                                                                                                        }
                                                                                                                      } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletepos" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('deletepos', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                    </tr>


                    <tr>
                      <td>Pelanggan</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createpelanggan" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('createpelanggan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatepelanggan" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('updatepelanggan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewpelanggan" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('viewpelanggan', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletepelanggan" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('deletepelanggan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                    </tr>


                    <tr>
                      <td>Penjualan</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createpenjualan" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('createpenjualan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatepenjualan" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('updatepenjualan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewpenjualan" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('viewpenjualan', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletepenjualan" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('deletepenjualan', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                    </tr>


                    <tr>
                      <td>Voucher</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createvoucher" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('createvoucher', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatevoucher" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updatevoucher', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewvoucher" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewvoucher', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletevoucher" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('deletevoucher', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                    </tr>


                    <tr>
                      <td>Dapur Produksi</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createdapro" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('createdapro', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatedapro" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('updatedapro', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewdapro" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('viewdapro', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletedapro" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('deletedapro', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                    </tr>

                    <tr>
                      <td>Reports</td>
                      <td> - </td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewReports" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewReports', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Perusahaan</td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCompany" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updateCompany', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td> - </td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Profil</td>
                      <td> - </td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProfile" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewProfile', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Pengaturan</td>
                      <td>-</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateSetting" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updateSetting', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td> - </td>
                      <td> - </td>
                    </tr>
                  </tbody>
                </table>

              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#mainGroupNav").addClass('active');
    $("#manageGroupNav").addClass('active');

    $('input[type="checkbox"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
  });
</script>