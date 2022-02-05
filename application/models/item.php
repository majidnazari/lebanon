<?php

class Item extends CI_Model {
    function GetPosition($status = '', $row, $limit) {
        $this->db->select('tbl_positions.*');
        $this->db->from('tbl_positions');
        if($status != '')
            $this->db->where('tbl_positions.status', $status);

        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function SearchPosition($status = '', $description) {
        $this->db->select('tbl_positions.*');
        $this->db->from('tbl_positions');
        if($description != '') {
            $this->db->like('tbl_positions.label_en', $description);
            $this->db->or_like('tbl_positions.label_ar', $description);
        }

        if($status != '')
            $this->db->like('tbl_positions.status', $status);

        $query = $this->db->get();
        return $query->result();
    }

    function GetPositionById($id) {
        $this->db->select('tbl_positions.*');
        $this->db->from('tbl_positions');
        $this->db->where('tbl_positions.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetNextHeadingById($id) {
        $this->db->select('tbl_heading.*');
        $this->db->from('tbl_heading');
        $this->db->where('tbl_heading.id > ', $id);
        $this->db->order_by('tbl_heading.id', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetSubHeadingByChapterId($status = '', $chapter) {
        $this->db->select('tbl_heading.*');
        $this->db->from('tbl_heading');
        if($status != '')
            $this->db->where('tbl_heading.status', $status);
        $this->db->where('tbl_heading.chapter_id', $chapter);
        $this->db->order_by('tbl_heading.hs_code_print', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    function GetSubHeading($status = '', $row, $limit) {
        $this->db->select('tbl_subhead.*');
        $this->db->from('tbl_subhead');
        if($status != '')
            $this->db->where('tbl_subhead.status', $status);
        $this->db->order_by('tbl_subhead.code', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function SearchSubHeading($status, $code, $description) {
        $this->db->select('tbl_subhead.*');
        $this->db->from('tbl_subhead');
        if($description != '') {
            $this->db->like('tbl_subhead.title_en', $description);
            $this->db->or_like('tbl_subhead.title_ar', $description);
        }

        if($status != '')
            $this->db->like('tbl_subhead.status', $status);
        if($code != '')
            $this->db->like('tbl_subhead.code', $code);
        $this->db->order_by('tbl_subhead.code', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSector($status = '', $row, $limit) {
        $this->db->select('tbl_sectors.*');
        $this->db->from('tbl_sectors');
        if($status != '')
            $this->db->where('tbl_sectors.status', $status);
        $this->db->order_by('tbl_sectors.rank', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetSectorById($id) {
        $this->db->select('tbl_sectors.*');
        $this->db->from('tbl_sectors');
        $this->db->where('tbl_sectors.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function SearchSector($status, $description) {
        $this->db->select('tbl_sectors.*');
        $this->db->from('tbl_sectors');
        if($description != '') {
            $this->db->like('tbl_sectors.label_en', $description);
            $this->db->or_like('tbl_sectors.label_ar', $description);
            $this->db->or_like('tbl_sectors.intro_ar', $description);
            $this->db->or_like('tbl_sectors.intro_en', $description);
        }

        if($status != '')
            $this->db->like('tbl_sectors.status', $status);
        $this->db->order_by('tbl_sectors.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSection($status = '', $row, $limit) {
        $this->db->select('tbl_section.*');
        $this->db->select('tbl_sectors.label_ar as sector_ar');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->from('tbl_section');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
        if($status != '')
            $this->db->where('tbl_section.status', $status);
        $this->db->order_by('tbl_section.label_en', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetSectionById($id) {
        $this->db->select('tbl_section.*');
        $this->db->select('tbl_sectors.label_ar as sector_ar');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->from('tbl_section');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
        $this->db->where('tbl_section.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetSectionsBySectorId($status = '', $sector) {
        $this->db->select('tbl_section.*');
        $this->db->select('tbl_sectors.label_ar as sector_ar');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->from('tbl_section');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
        if($status != '')
            $this->db->where('tbl_section.status', $status);
        if($sector != 0)
            $this->db->where('tbl_section.sector_id', $sector);
        $this->db->order_by('tbl_section.scn_nbr', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetChaptersBySectionId($status = '', $section) {
        $this->db->select('tbl_chapter.*');
        $this->db->from('tbl_chapter');
        if($status != '')
            $this->db->where('tbl_chapter.status', $status);
        if($section != 0)
            $this->db->where('tbl_chapter.section_id', $section);
        $this->db->order_by('tbl_chapter.cha_nbr', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function SearchSection($status, $description, $sector) {
        $this->db->select('tbl_section.*');
        $this->db->select('tbl_sectors.label_ar as sector_ar');
        $this->db->select('tbl_sectors.label_en as sector_en');
        $this->db->from('tbl_section');
        $this->db->join('tbl_sectors', 'tbl_sectors.id = tbl_section.sector_id', 'inner');
        if($sector != 0)
            $this->db->where('tbl_section.sector_id', $sector);
        if($description != '') {
            //$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
            //$this->db->or_like('tbl_section.label_ar',$description);
            $where = "( tbl_section.label_en LIKE '%$description%' OR tbl_section.label_ar LIKE '%$description%')";
            $this->db->where($where);
        }

        if($status != '')
            $this->db->like('tbl_section.status', $status);

        $this->db->order_by('tbl_section.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetChapter($status = '', $row, $limit) {
        $this->db->select('tbl_chapter.*');
        $this->db->select('tbl_section.label_ar as section_ar');
        $this->db->select('tbl_section.label_en as section_en');
        $this->db->select('tbl_section.sector_id as sector_id');
        $this->db->from('tbl_chapter');
        $this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
        if($status != '')
            $this->db->where('tbl_chapter.status', $status);
        $this->db->order_by('tbl_chapter.label_en', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetChapterById($id) {
        $this->db->select('tbl_chapter.*');
        $this->db->select('tbl_section.label_ar as section_ar');
        $this->db->select('tbl_section.label_en as section_en');
        $this->db->select('tbl_section.sector_id as sector_id');
        $this->db->from('tbl_chapter');
        $this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
        $this->db->where('tbl_chapter.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function SearchChapter($status, $description, $section, $sector) {
        $this->db->select('tbl_chapter.*');
        $this->db->select('tbl_section.label_ar as section_ar');
        $this->db->select('tbl_section.label_en as section_en');
        $this->db->select('tbl_section.sector_id as sector_id');
        $this->db->from('tbl_chapter');
        $this->db->join('tbl_section', 'tbl_section.id = tbl_chapter.section_id', 'inner');
        if($section != 0)
            $this->db->where('tbl_chapter.section_id', $section);
        if($sector != 0)
            $this->db->where('tbl_section.sector_id', $sector);

        if($description != '') {
            //$this->db->like("(tbl_section.label_en=".$description." OR tbl_section.label_ar=".$description.")", NULL, FALSE);
            //$this->db->or_like('tbl_section.label_ar',$description);
            $where = "( tbl_chapter.label_en LIKE '%$description%' OR tbl_chapter.label_ar LIKE '%$description%')";
            $this->db->where($where);
        }

        if($status != '')
            $this->db->like('tbl_chapter.status', $status);

        $this->db->order_by('tbl_chapter.label_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetItemById($id) {
        $this->db->select('tbl_heading.*');
        $this->db->select('tbl_chapter.label_ar as chapter_ar');
        $this->db->select('tbl_chapter.label_en as chapter_en');
        $this->db->select('tbl_subhead.title_en as subhead_en');
        $this->db->select('tbl_subhead.title_ar as subhead_ar');
        $this->db->from('tbl_heading');
        $this->db->join('tbl_chapter', 'tbl_chapter.id = tbl_heading.chapter_id', 'left');
        $this->db->join('tbl_subhead', 'tbl_subhead.id = tbl_heading.subhead_id', 'left');
        $this->db->where('tbl_heading.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetItems($status = '', $row, $limit) {
        $this->db->select('tbl_heading.*');
        $this->db->select('tbl_chapter.label_ar as chapter_ar');
        $this->db->select('tbl_chapter.label_en as chapter_en');
        $this->db->select('tbl_subhead.title_en as subhead_en');
        $this->db->select('tbl_subhead.title_ar as subhead_ar');
        $this->db->from('tbl_heading');
        $this->db->join('tbl_chapter', 'tbl_chapter.id = tbl_heading.chapter_id', 'left');
        $this->db->join('tbl_subhead', 'tbl_subhead.id = tbl_heading.subhead_id', 'left');
        if($status != '')
            $this->db->where('tbl_heading.status', $status);
        $this->db->order_by('tbl_heading.label_en', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function SearchItems($code, $item, $description, $status = FALSE, $row, $limit) {
        $this->db->select('tbl_heading.*');
        $this->db->select('tbl_chapter.label_ar as chapter_ar');
        $this->db->select('tbl_chapter.label_en as chapter_en');
        $this->db->select('tbl_subhead.title_en as subhead_en');
        $this->db->select('tbl_subhead.title_ar as subhead_ar');
        $this->db->from('tbl_heading');
        $this->db->join('tbl_chapter', 'tbl_chapter.id = tbl_heading.chapter_id', 'left');
        $this->db->join('tbl_subhead', 'tbl_subhead.id = tbl_heading.subhead_id', 'left');
        /*
          if($chapter!=0)
          $this->db->where('tbl_heading.chapter_id',$chapter);
          if($sub_heading!=0)
          $this->db->where('tbl_heading.subhead_id',$sub_heading);
         */
        if($item != '') {
            $where1 = "( tbl_heading.label_en LIKE '%$item%' OR tbl_heading.label_ar LIKE '%$item%')";
            $this->db->where($where1);
        }
        if($description != '') {
            $where2 = "( tbl_heading.description_en LIKE '%$description%' OR tbl_heading.description_ar LIKE '%$description%')";
            $this->db->where($where2);
        }
        if($code != '') {
            $where3 = "( tbl_heading.hs_code LIKE '%$code%' OR tbl_heading.hs_code_print LIKE '%$code%')";
            $this->db->where($where3);
        }
        /*
          if($status!='')
          $this->db->like('tbl_heading.status',$status);
         */
        $this->db->order_by('tbl_heading.hs_code', 'ASC');
        $this->db->order_by('tbl_heading.label_en', 'ASC');
        $this->db->order_by('tbl_heading.label_ar', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetItemsByCode($code, $id) {
        $this->db->select('tbl_heading.*');
        $this->db->select('tbl_chapter.label_ar as chapter_ar');
        $this->db->select('tbl_chapter.label_en as chapter_en');
        $this->db->select('tbl_subhead.title_en as subhead_en');
        $this->db->select('tbl_subhead.title_ar as subhead_ar');
        $this->db->from('tbl_heading');
        $this->db->join('tbl_chapter', 'tbl_chapter.id = tbl_heading.chapter_id', 'left');
        $this->db->join('tbl_subhead', 'tbl_subhead.id = tbl_heading.subhead_id', 'left');
        if($code != '')
            $this->db->like('tbl_heading.hs_code_print', $code);
        $this->db->where('tbl_heading.id !=', $id);
        $this->db->order_by('tbl_heading.label_en', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    function GetItemByCode($code) {
        $this->db->select('tbl_heading.*');
        $this->db->select('tbl_chapter.label_ar as chapter_ar');
        $this->db->select('tbl_chapter.label_en as chapter_en');
        $this->db->select('tbl_subhead.title_en as subhead_en');
        $this->db->select('tbl_subhead.title_ar as subhead_ar');
        $this->db->from('tbl_heading');
        $this->db->join('tbl_chapter', 'tbl_chapter.id = tbl_heading.chapter_id', 'left');
        $this->db->join('tbl_subhead', 'tbl_subhead.id = tbl_heading.subhead_id', 'left');
        if($code != '')
            $this->db->like('tbl_heading.hs_code', $code);
        $this->db->order_by('tbl_heading.label_en', 'ASC');

        $query = $this->db->get();
        return $query->row_array();
    }

    function GetItemRating($id) {
        $this->db->select('tbl_heading_rate.*');
        $this->db->select('tbl_countries.label_ar as country_ar');
        $this->db->select('tbl_countries.label_en as country_en');
        $this->db->from('tbl_heading_rate');
        $this->db->join('tbl_countries', 'tbl_countries.id = tbl_heading_rate.country_id', 'left');
        $this->db->where('tbl_heading_rate.heading_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function GetItemRatingById($id) {
        $this->db->select('tbl_heading_rate.*');
        $this->db->select('tbl_countries.label_ar as country_ar');
        $this->db->select('tbl_countries.label_en as country_en');
        $this->db->from('tbl_heading_rate');
        $this->db->join('tbl_countries', 'tbl_countries.id = tbl_heading_rate.country_id', 'left');
        $this->db->where('tbl_heading_rate.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetSubhead($status = '', $row, $limit) {
        $this->db->select('tbl_subhead.*');
        $this->db->from('tbl_subhead');
        if($status != '')
            $this->db->where('tbl_subhead.status', $status);
        $this->db->order_by('tbl_subhead.title_ar', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetSubheadById($id) {
        $this->db->select('tbl_subhead.*');
        $this->db->from('tbl_subhead');
        $this->db->where('tbl_subhead.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function SearchSubhead($code, $description, $status = FALSE, $row, $limit) {
        $this->db->select('tbl_subhead.*');
        $this->db->from('tbl_subhead');
        if($description != '') {
            $where1 = "( tbl_subhead.title_en LIKE '%$description%' OR tbl_subhead.title_ar LIKE '%$description%')";
            $this->db->where($where1);
        }
        if($code != '') {
            $where3 = "( tbl_subhead.code LIKE '%$code%')";
            $this->db->where($where3);
        }
        /*
          if($status!='')
          $this->db->like('tbl_heading.status',$status);
         */
        $this->db->order_by('tbl_subhead.code', 'ASC');
        $this->db->order_by('tbl_subhead.title_en', 'ASC');
        $this->db->order_by('tbl_subhead.title_ar', 'ASC');
        if($limit != 0)
            $this->db->limit($limit, $row);
        $query = $this->db->get();
        return $query->result();
    }

    function GetCountryById($id) {
        $this->db->select('countries.*');
        $this->db->from('countries');
        $this->db->where('countries.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetCitiesByCountryId($country_id) {
        $this->db->select('cities.*');
        $this->db->from('cities');
        $this->db->order_by('city', 'ASC');
        $this->db->where('cities.countryid', $country_id);
        $query = $this->db->get();
        return $query->result();
    }

    function GetCityId($id) {
        $this->db->select('cities.*');
        $this->db->from('cities');
        $this->db->where('cities.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GetSponsors($status = '') {
        $this->db->select('tbl_sponsors.*');
        $this->db->from('tbl_sponsors');
        $this->db->order_by('tbl_sponsors.title_en', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSponsorById($id) {
        $this->db->select('tbl_sponsors.*');
        $this->db->from('tbl_sponsors');
        $this->db->where('tbl_sponsors.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

}