<?php

/**
 * Models     : Datatables serverside based php
 * Modified   : Fauzan Falah
 * Website    : https://www.codekop.com/
 * 
 * 
 * 
 * 
 */
class M_Datatables extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_tables($tables, $cari, $iswhere)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        $query = $tables;

        if (!empty($iswhere)) {
            $sql = $this->db->query("SELECT * FROM " . $query . " WHERE " . $iswhere);
        } else {
            $sql = $this->db->query("SELECT * FROM " . $query);
        }

        $sql_count = $sql->num_rows();

        $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";


        // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_field = $_POST['order'][0]['column'];

        // Untuk menentukan order by "ASC" atau "DESC"
        $order_ascdesc = $_POST['order'][0]['dir'];
        $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

        if (!empty($iswhere)) {
            $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
        } else {
            $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
        }

        if (isset($search)) {
            if (!empty($iswhere)) {
                $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere (" . $cari . ")");
            } else {
                $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE (" . $cari . ")");
            }
            $sql_filter_count = $sql_cari->num_rows();
        } else {
            if (!empty($iswhere)) {
                $sql_filter = $this->db->query("SELECT * FROM " . $query . "WHERE " . $iswhere);
            } else {
                $sql_filter = $this->db->query("SELECT * FROM " . $query);
            }
            $sql_filter_count = $sql_filter->num_rows();
        }
        $data = $sql_data->result_array();

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $data
        );
        return json_encode($callback); // Convert array $callback ke json
    }

    function get_tables_where($tables, $cari, $where, $iswhere)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        $setWhere = array();
        foreach ($where as $key => $value) {
            $setWhere[] = $key . "='" . $value . "'";
        }

        $fwhere = implode(' AND ', $setWhere);

        if (!empty($iswhere)) {
            $sql = $this->db->query("SELECT * FROM " . $tables . " WHERE $iswhere AND " . $fwhere);
        } else {
            $sql = $this->db->query("SELECT * FROM " . $tables . " WHERE " . $fwhere);
        }
        $sql_count = $sql->num_rows();

        $query = $tables;
        $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

        // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_field = $_POST['order'][0]['column'];

        // Untuk menentukan order by "ASC" atau "DESC"
        $order_ascdesc = $_POST['order'][0]['dir'];
        $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

        if (!empty($iswhere)) {
            $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
        } else {
            $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
        }

        if (isset($search)) {
            if (!empty($iswhere)) {
                $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
            } else {
                $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE " . $fwhere . " AND (" . $cari . ")");
            }
            $sql_filter_count = $sql_cari->num_rows();
        } else {
            if (!empty($iswhere)) {
                $sql_filter = $this->db->query("SELECT * FROM " . $tables . " WHERE $iswhere AND " . $fwhere);
            } else {
                $sql_filter = $this->db->query("SELECT * FROM " . $tables . " WHERE " . $fwhere);
            }
            $sql_filter_count = $sql_filter->num_rows();
        }

        $data = $sql_data->result_array();

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $data
        );
        return json_encode($callback); // Convert array $callback ke json
    }

    function get_tables_query($query, $cari, $where, $iswhere)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        if ($where != null) {
            $setWhere = array();
            foreach ($where as $key => $value) {
                $setWhere[] = $key . "='" . $value . "'";
            }
            $fwhere = implode(' AND ', $setWhere);

            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere AND " . $fwhere);
            } else {
                $sql = $this->db->query($query . " WHERE " . $fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere AND " . $fwhere);
                } else {
                    $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        } else {
            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere ");
            } else {
                $sql = $this->db->query($query);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere");
                } else {
                    $sql_filter = $this->db->query($query);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        }

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $data
        );
        return json_encode($callback); // Convert array $callback ke json
    }


    function get_tables_query_csrf($query, $cari, $where, $isWhere, $csrf_name, $csrf_hash)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        if ($where != null) {
            $setWhere = array();
            foreach ($where as $key => $value) {
                $setWhere[] = $key . "='" . $value . "'";
            }

            $fwhere = implode(' AND ', $setWhere);
            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere " . $fwhere);
            } else {
                $sql = $this->db->query($query . " WHERE " . $fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere " . $fwhere . " AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere " . $fwhere);
                } else {
                    $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }

            $data = $sql_data->result_array();
        } else {

            if (!empty($iswhere)) {
                $sql = $this->db->query($query . "WHERE $isWhere");
            } else {
                $sql = $this->db->query($query);
            }

            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $isWhere (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $isWhere (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {

                if (!empty($iswhere)) {
                    $sql_filter =  $this->db->query($query . " WHERE $isWhere");
                } else {
                    $sql_filter = $this->db->query($query);
                }

                $sql_filter_count = $sql_filter->num_rows();
            }

            $data = $sql_data->result_array();
        }

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $data
        );
        $callback[$csrf_name] = $csrf_hash;

        return json_encode($callback); // Convert array $callback ke json
    }


















    // ============================= Model Query Kelas ==============================
    function get_query_kelas($query, $cari, $where, $iswhere)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        if ($where != null) {
            $setWhere = array();
            foreach ($where as $key => $value) {
                $setWhere[] = $key . "='" . $value . "'";
            }
            $fwhere = implode(' AND ', $setWhere);

            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere AND " . $fwhere);
            } else {
                $sql = $this->db->query($query . " WHERE " . $fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere AND " . $fwhere);
                } else {
                    $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        } else {
            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere ");
            } else {
                $sql = $this->db->query($query);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere");
                } else {
                    $sql_filter = $this->db->query($query);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        }


        $cek_data = $data;
        $nestedData = array();
        $hasil = array();


        foreach ($data as $key => $data) {
            // Array Data
            $id_km = $data['class_leader'];
            $data_km = $this->db->query("SELECT * FROM user WHERE id = '" . $id_km . "'")->row_array();
            $wakil = $this->db->query("SELECT * FROM user WHERE id = '" . $data['vice_leader'] . "'")->row_array();

            $kelas = $data['class'];
            $hitung = $this->db->query("SELECT count(id) as jumlah FROM user where class_name = '" . $kelas . "'")->row_array();

            $nestedData['class'] = $data['class'];
            $nestedData['name'] = $data['name'];
            $nestedData['class_leader'] = $data_km['name'];
            $nestedData['vice_leader'] = $wakil['name'];
            $nestedData['jumlah'] = $hitung['jumlah'];
            $nestedData['class_id'] = $data['class_id'];
            $nestedData['status'] = $data['status'];
            $hasil[] = $nestedData;
        }

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $hasil
        );
        return json_encode($callback); // Convert array $callback ke json
    }



    // ============================= Model Query Mapel ==============================
    function get_query_mapel($query, $cari, $where, $iswhere)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        if ($where != null) {
            $setWhere = array();
            foreach ($where as $key => $value) {
                $setWhere[] = $key . "='" . $value . "'";
            }
            $fwhere = implode(' AND ', $setWhere);

            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere AND " . $fwhere);
            } else {
                $sql = $this->db->query($query . " WHERE " . $fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere AND " . $fwhere);
                } else {
                    $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        } else {
            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere ");
            } else {
                $sql = $this->db->query($query);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere");
                } else {
                    $sql_filter = $this->db->query($query);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        }


        $cek_data = $data;
        $nestedData = array();
        $hasil = array();


        foreach ($data as $key => $data) {
            // Array Data

            $num = $this->db->query("SELECT * FROM teacher_lessons where lessons_id = '" . $data['mapel_id'] . "'")->num_rows();

            $nestedData['mapel_id'] = $data['mapel_id'];
            $nestedData['lessons'] = $data['lessons'];
            $nestedData['grade'] = $data['grade'];
            $nestedData['guru'] = $num;
            $hasil[] = $nestedData;
        }

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $hasil
        );
        return json_encode($callback); // Convert array $callback ke json
    }





    // ============================= Model Query Rekap Bulanan ==============================
    function get_tables_rekap_bulanan($query, $cari, $where, $iswhere, $awal = "", $akhir = "")
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        if ($where != null) {
            $setWhere = array();
            foreach ($where as $key => $value) {
                $setWhere[] = $key . "='" . $value . "'";
            }
            $fwhere = implode(' AND ', $setWhere);

            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere AND " . $fwhere);
            } else {
                $sql = $this->db->query($query . " WHERE " . $fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere AND " . $fwhere);
                } else {
                    $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        } else {
            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere ");
            } else {
                $sql = $this->db->query($query);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere");
                } else {
                    $sql_filter = $this->db->query($query);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        }


        $cek_data = $data;
        $nestedData = array();
        $hasil = array();


        foreach ($data as $key => $data) {
            // Array Data

            $tidak_hadir = 0;
            $semua = 0;
            $persentase = 0;
            $hadir = $this->db->query("SELECT * FROM student_attendance WHERE user_id = '" . $data['id'] . "' AND status = '1' AND date > '" . $awal . "' AND date < '" . $akhir . "'")->num_rows();
            $sakit = $this->db->query("SELECT * FROM student_attendance WHERE user_id = '" . $data['id'] . "' AND status = '3' AND date > '" . $awal . "' AND date < '" . $akhir . "'")->num_rows();
            $izin = $this->db->query("SELECT * FROM student_attendance WHERE user_id = '" . $data['id'] . "' AND status = '4' AND date > '" . $awal . "' AND date < '" . $akhir . "'")->num_rows();
            $alpha = $this->db->query("SELECT * FROM student_attendance WHERE user_id = '" . $data['id'] . "' AND status = '0' AND date > '" . $awal . "' AND date < '" . $akhir . "' AND description != 'Bolos' AND description != 'PKL/OJT'")->num_rows();
            $pkl = $this->db->query("SELECT * FROM student_attendance WHERE user_id = '" . $data['id'] . "' AND status = '0' AND date > '" . $awal . "' AND date < '" . $akhir . "' AND description = 'PKL/OJT'")->num_rows();
            $bolos = $this->db->query("SELECT * FROM student_attendance WHERE user_id = '" . $data['id'] . "' AND status = '0' AND date > '" . $awal . "' AND date < '" . $akhir . "' AND description = 'Bolos'")->num_rows();
            $tidak_hadir = $sakit + $izin + $alpha + $bolos;
            $total_hadir = $hadir + $pkl;
            $semua = $total_hadir + $tidak_hadir;
            if ($semua != 0) {
                $persentase = number_format(($hadir / $semua) * 100, 2);
            }


            $update = [
                'view_sakit' => $sakit,
                'view_izin' => $izin,
                'view_alpha' => $alpha,
                'view_hadir' => $hadir,
                'view_bolos' => $bolos,
                'view_pkl' => $pkl,
                'view_tidak_hadir' => $tidak_hadir,
                'view_persentase' => $persentase
            ];
            $this->db->where('id', $data['id']);
            $this->db->update('user', $update);

            $nestedData['name'] = $data['name'];
            $nestedData['view_hadir'] = $data['view_hadir'];
            $nestedData['view_sakit'] = $data['view_sakit'];
            $nestedData['view_izin'] = $data['view_izin'];
            $nestedData['view_alpha'] = $data['view_alpha'];
            $nestedData['view_pkl'] = $data['view_pkl'];
            $nestedData['view_bolos'] = $data['view_bolos'];
            $nestedData['view_tidak_hadir'] = $data['view_tidak_hadir'];
            $nestedData['view_persentase'] = $data['view_persentase'] . "%";
            $hasil[] = $nestedData;
        }

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $hasil
        );
        return json_encode($callback); // Convert array $callback ke json
    }





    // ============================= Model Monitoring Ruangan ==============================
    function get_monitoring_ruangan($query, $cari, $where, $iswhere)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        if ($where != null) {
            $setWhere = array();
            foreach ($where as $key => $value) {
                $setWhere[] = $key . "='" . $value . "'";
            }
            $fwhere = implode(' AND ', $setWhere);

            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere AND " . $fwhere);
            } else {
                $sql = $this->db->query($query . " WHERE " . $fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere AND " . $fwhere);
                } else {
                    $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        } else {
            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere ");
            } else {
                $sql = $this->db->query($query);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere");
                } else {
                    $sql_filter = $this->db->query($query);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        }


        $cek_data = $data;
        $nestedData = array();
        $hasil = array();


        foreach ($data as $key => $data) {
            // Array Data
            $status_ruangan = 0;
            $room = 0;
            $room = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data['room_id'] . "' AND is_done = '0'")->num_rows();

            $nestedData['pic'] = $data['name'];
            $nestedData['description'] = $data['description'];
            $nestedData['is_done'] = $status_ruangan;
            $hasil[] = $nestedData;
        }

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $hasil
        );
        return json_encode($callback); // Convert array $callback ke json
    }




    // ============================= Model Query Rekap Bulanan ==============================
    function get_tables_rekap_siswa($query, $cari, $where, $iswhere)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        if ($where != null) {
            $setWhere = array();
            foreach ($where as $key => $value) {
                $setWhere[] = $key . "='" . $value . "'";
            }
            $fwhere = implode(' AND ', $setWhere);

            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere AND " . $fwhere);
            } else {
                $sql = $this->db->query($query . " WHERE " . $fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere AND " . $fwhere);
                } else {
                    $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        } else {
            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere ");
            } else {
                $sql = $this->db->query($query);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere");
                } else {
                    $sql_filter = $this->db->query($query);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        }


        $cek_data = $data;
        $nestedData = array();
        $hasil = array();


        foreach ($data as $key => $data) {
            // Array Data
            $room = $this->db->query("SELECT * FROM student_room WHERE room_id = '" . $data['room_id'] . "'")->row_array();
            $guru = $this->db->query("SELECT * FROM user WHERE id = '" . $data['teacher_id'] . "'")->row_array();
            $lessons = $this->db->query("SELECT * FROM student_lessons where mapel_id = '" . $data['lessons_id'] . "'")->row_array();

            $nestedData['date'] = $data['date'];
            $nestedData['time'] = $data['time'];
            $nestedData['lessons_id'] = $lessons['lessons'];
            $nestedData['teacher_id'] = $guru['name'];
            $nestedData['room_id'] = $room['no'] . " - " . $room['description'];
            $nestedData['status'] = $data['status'];
            $hasil[] = $nestedData;
        }

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $hasil
        );
        return json_encode($callback); // Convert array $callback ke json
    }

















    function get_query_auto($query, $cari, $where, $iswhere)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        if ($where != null) {
            $setWhere = array();
            foreach ($where as $key => $value) {
                $setWhere[] = $key . "='" . $value . "'";
            }
            $fwhere = implode(' AND ', $setWhere);

            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere AND " . $fwhere);
            } else {
                $sql = $this->db->query($query . " WHERE " . $fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere AND " . $fwhere);
                } else {
                    $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        } else {
            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere ");
            } else {
                $sql = $this->db->query($query);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere");
                } else {
                    $sql_filter = $this->db->query($query);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        }

        $cek_data = $data;
        $nestedData = array();
        $hasil = array();


        foreach ($data as $key => $data) {
            // Array Data
            $data_attendance = $this->db->query("SELECT * FROM student_attendance WHERE date = '" . date('Y-m-d') . "' AND user_id = '" . $data['id'] . "'")->num_rows();
            $konfirmasi = "confirm('Apakah anda Yakin?')";
            if ($data_attendance == 0) {
                $isi_aksi = '<a type="button" class="btn btn-primary" onclick="return ' . $konfirmasi . '" href="' . base_url('auto/manual/' . $data['id']) . '">Isert Data</a>';
            } else {
                $isi_aksi = 'Data Sudah Ada';
            }

            $nestedData['id'] = $data['id'];
            $nestedData['name'] = $data['name'];
            $nestedData['aksi'] = $isi_aksi;
            // $nestedData['guru'] = $num;
            $hasil[] = $nestedData;
        }

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $hasil
        );
        return json_encode($callback); // Convert array $callback ke json
    }




















    // ============================= Model Query History Bulanan ==============================
    function get_query_history_bulanan($query, $cari, $where, $iswhere, $awal, $akhir, $teacher_id, $lessons_id)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        if ($where != null) {
            $setWhere = array();
            foreach ($where as $key => $value) {
                $setWhere[] = $key . "='" . $value . "'";
            }
            $fwhere = implode(' AND ', $setWhere);

            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere AND " . $fwhere);
            } else {
                $sql = $this->db->query($query . " WHERE " . $fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere AND " . $fwhere);
                } else {
                    $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        } else {
            if (!empty($iswhere)) {
                $sql = $this->db->query($query . " WHERE  $iswhere ");
            } else {
                $sql = $this->db->query($query);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column'];

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

            if (!empty($iswhere)) {
                $sql_data = $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            } else {
                $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
            }

            if (isset($search)) {
                if (!empty($iswhere)) {
                    $sql_cari =  $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")");
                } else {
                    $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            } else {
                if (!empty($iswhere)) {
                    $sql_filter = $this->db->query($query . " WHERE $iswhere");
                } else {
                    $sql_filter = $this->db->query($query);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        }


        $cek_data = $data;
        $nestedData = array();
        $hasil = array();


        foreach ($data as $key => $data) {
            // Array Data

            $tidak_hadir = 0;
            $semua = 0;
            $persentase = 0;


            // $hadir = $this->db->query("SELECT student_room_id FROM student_room_absent WHERE student_id = '" . $data['id'] . "' AND lessons_id = '0' AND status = '1' AND tanggal > '" . $awal . "' AND tanggal < '" . $akhir . "'")->num_rows();
            // $sakit = $this->db->query("SELECT student_room_id FROM student_room_absent WHERE student_id = '" . $data['id'] . "' AND lessons_id = '0' AND status = '3' AND tanggal > '" . $awal . "' AND tanggal < '" . $akhir . "'")->num_rows();
            // $izin = $this->db->query("SELECT student_room_id FROM student_room_absent WHERE student_id = '" . $data['id'] . "' AND lessons_id = '0' AND status = '4' AND tanggal > '" . $awal . "' AND tanggal < '" . $akhir . "'")->num_rows();
            // $alpha = $this->db->query("SELECT student_room_id FROM student_room_absent WHERE student_id = '" . $data['id'] . "' AND lessons_id = '0' AND status = '0' AND tanggal > '" . $awal . "' AND tanggal < '" . $akhir . "' AND description != 'Bolos' AND description != 'PKL/OJT'")->num_rows();
            // $pkl = $this->db->query("SELECT student_room_id FROM student_room_absent WHERE student_id = '" . $data['id'] . "' AND lessons_id = '0' AND status = '0' AND tanggal > '" . $awal . "' AND tanggal < '" . $akhir . "' AND description = 'PKL/OJT'")->num_rows();
            // $bolos = $this->db->query("SELECT student_room_id FROM student_room_absent WHERE student_id = '" . $data['id'] . "' AND lessons_id = '0' AND status = '0' AND tanggal > '" . $awal . "' AND tanggal < '" . $akhir . "' AND description = 'Bolos'")->num_rows();


            $hadir = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '1' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "'")->num_rows();
            $sakit = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '3' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "'")->num_rows();
            $izin = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '4' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "'")->num_rows();
            $alpha = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description ='Alfa'")->num_rows();
            $pkl = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description = 'PKL/OJT'")->num_rows();
            $bolos = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description = 'Bolos'")->num_rows();

            $dispensasi = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description = 'Dispensasi'")->num_rows();

            $tugas = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description = 'Tugas Luar/Tugas Sekolah'")->num_rows();



            $tidak_hadir = $sakit + $izin + $alpha + $bolos + $dispensasi + $tugas;
            $total_hadir = $hadir + $pkl;
            $semua = $total_hadir + $tidak_hadir;
            if ($semua != 0) {
                $persentase = number_format(($hadir / $semua) * 100, 2);
            }


            $update = [
                'view_sakit' => $sakit,
                'view_izin' => $izin,
                'view_alpha' => $alpha,
                'view_hadir' => $hadir,
                'view_bolos' => $bolos,
                'view_pkl' => $pkl,
                'view_dispensasi' => $dispensasi,
                'view_tugas' => $tugas,
                'view_tidak_hadir' => $tidak_hadir,
                'view_persentase' => $persentase
            ];
            $this->db->where('id', $data['id']);
            $this->db->update('user', $update);

            $nestedData['name'] = $data['name'];
            $nestedData['class_name'] = $data['class_name'];
            $nestedData['view_hadir'] = $data['view_hadir'];
            $nestedData['view_sakit'] = $data['view_sakit'];
            $nestedData['view_izin'] = $data['view_izin'];
            $nestedData['view_alpha'] = $data['view_alpha'];
            $nestedData['view_pkl'] = $data['view_pkl'];
            $nestedData['view_bolos'] = $data['view_bolos'];
            $nestedData['view_dispensasi'] = $data['view_dispensasi'];
            $nestedData['view_tugas'] = $data['view_tugas'];
            $nestedData['view_tidak_hadir'] = $data['view_tidak_hadir'];
            $nestedData['view_persentase'] = $data['view_persentase'] . "%";
            $hasil[] = $nestedData;
        }

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $hasil
        );
        return json_encode($callback); // Convert array $callback ke json
    }
}
