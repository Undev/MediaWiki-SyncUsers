<?php
class SyncUsers extends ApiBase
{
	public function execute()
	{
		$file = file_get_contents(__DIR__ . '/' . 'people.txt', true);

		$patterns[] = '/"/';
		$patterns[] = '/\[/';
		$patterns[] = '/\]/';
		$patterns[] = '/\,/';
		$people = preg_replace($patterns, '', $file);
		$people = explode(' ', $people);

		$users = array();
		$dismissed = array();
		foreach ($people as $email) {
			$dbw = wfGetDB(DB_MASTER);
			$res = $dbw->select('user',
				array(
					'user_id',
				),
				array(
					'user_email' => $email,
				), __METHOD__
			);

			if ($res->numRows()) {
				foreach ($res as $row) {
					if (isset($row->user_id)) {
						$users[] = $user = User::newFromId($row->user_id);
					}
				}
			} else {
				$dismissed[] = $email;
			}
		}

		$endOfLine = '<br>' . PHP_EOL;
		print 'People for analyzing: ' . count($people);
		print $endOfLine;
		print $endOfLine;

		print 'MediaWiki Account / GitLab Email (' . count($users) . '):';
		print $endOfLine;
		print $endOfLine;

		foreach ($users as $user) {
			print $user->getName() . ' / ' . $user->getEmail();
			print $endOfLine;
		}

		print $endOfLine;

		print 'Dismissed GitLab Email (' . count($dismissed) . '):';
		print $endOfLine;

		foreach ($dismissed as $email) {
			print $email;
			print $endOfLine;
		}

		return true;
	}
}