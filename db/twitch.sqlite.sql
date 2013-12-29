CREATE TABLE [downloads] (
[id] TEXT PRIMARY KEY NOT NULL,
[broadcast_id] TEXT  NOT NULL,
[video_id] TEXT  NOT NULL,
[path] TEXT  NULL,
[size] TEXT  NULL,
[video_url] TEXT  NULL,
[status] TEXT  NULL,
[created] TEXT  NULL
);

CREATE TABLE [ffmpegjobs] (
[id] TEXT  NOT NULL PRIMARY KEY,
[type] TEXT  NULL,
[video_id] TEXT  NULL,
[broadcast_id] TEXT  NULL,
[status] TEXT  NULL,
[created] TEXT  NULL
);

CREATE TABLE [videos] (
[id] TEXT  NULL PRIMARY KEY,
[broadcast_id] TEXT  NULL,
[status] TEXT  NULL,
[created] TEXT NULL
);
