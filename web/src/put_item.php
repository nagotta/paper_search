<?php

include('utils.php');

$putFilePath = "";

$metadata = array(
    "複数ファイルから生成したErasure Coding によるデータ保護方式の実装と評価",
    array(
        '[1]  IDC, "Data Age 2025:The Evolution of Data to Life-Critical Don’t Focus on Big Data; Focus on the Data That’s Big," [Online]. Available: https://www.seagate.com/files/www-content/our-story/trends/files/Seagate-WP-DataAge2025-March-2017.pdf. [Accessed 29 ',
        '[2]  Meta Platforms, Inc., "facebook," [Online]. Available: https://www.facebook.com/. [Accessed 5 2 2024]. ',
        '[3]  Meta, "Instagram," [Online]. Available: https://www.instagram.com/. [Accessed 5 2 2025]. [4]  X Corp., "X," [Online]. Available: https://twitter.com/. [Accessed 5 2 2024]. ',
        '[4]  X Corp., "X," [Online]. Available: https://twitter.com/. [Accessed 5 2 2024]. [5]  経済産業 省, "令和4 年度 規制改革推進のための国際連携事業(データ保護ないし越境移転に関連する諸外国の企業認証制度等に係る動向調査)," 2 2023. [Online]. Available: ',
        '[5]  経済産業省, "令和4 年度 規制改革推進のための国際連携事業(データ保護ないし越境移転に関連する諸外国の企業認証制度等に係る動向調査)," 2 2023. [Online]. Available: ',
        '[6]  EMC Education Services, IT 技術者なら知っておきたいストレージの原則と技術, インプレスジャパン, 2017, pp. 37-39. ',
        '[8]  一般社団法人 電子情報技術産業協会 テープストレージ専門委員会, "テープストレージ動向 <2018',
        '[9]  EMC Education Services, IT 技術者なら知っておきたいストレージの原則と技術, インプレスジャパン, 2017, pp. 91-92. ',
        '[10]  EMC Education Services, IT 技術者なら知っておきたいストレージの原則と技術, インプレスジャパン, 2017, pp. 149-159. ',
        '[11]  喜 連川 優, ストレージ技術ークラウドとビッグデータの時代ー, オーム社, 2015, pp. 141-',
        '[12]  Google, "Google Drive," [Online]. Available: https://www.google.com/intl/ja/drive/. [Accessed 5 2 2024]. ',
        '[13]  Dropbox, "Dropbox," [Online]. Available: https://www.dropbox.com/. [Accessed 5 2 2024]. ',
        '[14]  Microsoft, "OneDrive," [Online]. Available: https://www.microsoft.com/ja-jp/microsoft-365/onedrive/online-cloud-storage. [Accessed 5 2 2024]. ',
        '[15]  喜連川 優, ストレージ技術ークラウドとビッグデータの時代ー, オーム社, 2015, pp. 69-',
        '[16]  坂下 幸徳, 基礎からの新しいストレージ入門 基礎技術から設計・運用管理の実践まで, ソシム株式会社, 2023, p. 45. ',
        '[18]  喜連川 優, ストレージ技術ークラウドとビッグデータの時代ー, オーム社, 2015, pp. 72-',
        '[19]  I. S. Reed，G. Solomon, "Polynomial Codes Over Certain Finite Fields," Journal of the Society for Industrial and Applied Mathematics, 1960. ',
        '[20]  GitHub, [Online]. Available: https://github.com/openstack/liberasurecode. [Accessed 5 2 2024]. ',
        '[21]  MinIO, Inc., "MinIO," 5 2 2024. [Online]. Available: https://min.io/https://min.io/. ',
        '[22]  Red Hat, Inc., "GlusterFS," [Online]. Available: https://www.gluster.org/. [Accessed 5 2 2024]. ',
        '[23]  Ceph, "Ceph," [Online]. Available: https://ceph.io/en/. [Accessed 5 2 2024]. ',
        '[24]  Hitoshi Kamei，Shinya Matsumoto，Takaki Nakamura，Hiroaki Muraoka, "REC2: Restoration Method Using Combination of Replication and Erasure Coding," IEEE, 2016. ',
        '[25]  Shinya Matsumoto, Takaki Nakamura, Hiroaki Muraoka, "Risk-Aware Data Replication to Multiple Sites against Widespread Disasters," RANGSIT UNIVERSITY, 2013. ',
        '[26]  Takaki NAKAMURA, Shinya MATSUMOTO, Hiroaki MURAOKA, "Discreet Method to Match Safe Site-Pairs in Short Computation Time for Risk-Aware Data Replication," IEICE Transactions on Information and Systems, 2015. ',
        '[28]  MinIO, Inc., "mc cp," [Online]. Available: https://min.io/docs/minio/linux/reference/minio-mc/mc-cp.html. [Accessed 5 2 2024]. ',
        '[29]  Yu Lin Chen, NYU & Microsoft Corporation; Shuai Mu and Jinyang Li, NYU; Cheng Huang, Jin Li, Aaron Ogus, and Douglas Phillips, Microsoft Corporation, "Giza: Erasure Coding Objects across Global Data Centers," 2017 USENIX Annual Technical '
    ),
    48
);

// put_item()の引数はnginxから取得
put_item($putFilePath, $metadata);

?>