
-- populate roles table
INSERT INTO role (id, name)
VALUES(0, 'GUEST'),(1, 'USER'),(2, 'ADMIN')
ON CONFLICT (id) DO NOTHING;


-- add addmin
-- PW: admin
INSERT INTO public.user (username, email, pass_hash, salt, role_id)
VALUES (
        'admin',
        'admin@admin.de',
        '$2y$10$cXEQA.1QDizP/5O5bPy6xewJnXKGdSxOgILEbUhBBz2xQWmoQFrNC',
        '3aa1970330466759f4c5bed564b20033',
        2
       );

-- add user
-- PW: user
INSERT INTO public.user (username, email, pass_hash, salt, role_id, wallet)
VALUES (
           'user',
           'user@test.de',
           '$2y$10$TRXivKF8Vs6H0z48CxztAuGcBMH1kBXAuqhSotnTtMVxRNSah9csi',
           '3aae8f4b94b52969fe22c63d6ff83695',
           1,
        '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa'
       );

-- insert a favor for user
INSERT INTO public.favorite (nft_id, user_id)
VALUES (1,2);


-- add a transaction
INSERT INTO public.transaction (timestamp, nft_id, user_id, price)
VALUES (
        '2025-01-25 18:11:42.000 +0100',
        2,
        2,
        480
       );
-- and set the owner accordingly
UPDATE public.nft
SET owner_id = 2
WHERE id = 2;