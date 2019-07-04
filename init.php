<?php
class Pinboard extends Plugin {
        private $host;

        function init($host) {
                $this->host = $host;

                $host->add_hook($host::HOOK_ARTICLE_BUTTON, $this);
        }

        function about() {
                return array(1.2,
                        "Share article on Pinboard",
                        "m.s");
        }

        function get_js() {
                return file_get_contents(dirname(__FILE__) . "/pinboard.js");
        }

        function hook_article_button($line) {
                $article_id = $line["id"];

                $rv = "<img src=\"plugins.local/pinboard/pinboard.png\" 
                        class='tagsPic' style=\"cursor : pointer\" 
                        onclick=\"shareArticleToPinboard($article_id)\" 
                        title='".__('Share on Pinboard')."'>";

                return $rv;
		}
		
		function get_pdo() {
			return $this->pdo;
		}

        function getInfo() {
			$id = $_REQUEST['id'];
			$sth = $this->pdo->prepare("SELECT title, link 
										FROM ttrss_entries, ttrss_user_entries 
										WHERE id = ? AND ref_id = id  AND owner_uid = ?");
			$sth->execute([$id, $_SESSION['uid']]);
			
			if ($row = $sth->fetch()) {
				$title = truncate_string(strip_tags($row['title']), 100, '...');
				$article_link = $row['link'];
			}

                print json_encode(array("title" => $title, "link" => $article_link,
                                "id" => $id));
        }

        function api_version() {
                return 2;
        }

}