-- THIS IS DEPRECATED AND UNUSED
-- it was used initially to create the database, until we changed the setup
-- now the database gets created automatically based on our models (ORM)
CREATE TABLE public."role" (
                               id int NOT NULL,
                               "name" varchar NULL,
                               CONSTRAINT role_pk PRIMARY KEY (id)
);

CREATE TABLE public."user" (
                               id int NOT NULL,
                               username varchar NOT NULL,
                               pass_hash varchar NOT NULL,
                               salt varchar NOT NULL,
                               email varchar NULL,
                               wallet varchar NULL,
                               role_id int NOT NULL,
                               CONSTRAINT user_pk PRIMARY KEY (id),
                               CONSTRAINT user_unique UNIQUE (wallet),
                               CONSTRAINT role_id FOREIGN KEY (role_id) REFERENCES public."role"(id)
);

CREATE TABLE public.nft (
                            id int NOT NULL,
                            "name" varchar NOT NULL,
                            description varchar NOT NULL,
                            "type" varchar NULL,
                            price double precision NULL,
                            img varchar NULL,
                            owner_id int NULL,
                            CONSTRAINT nft_pk PRIMARY KEY (id),
                            CONSTRAINT "owner" FOREIGN KEY (owner_id) REFERENCES public."user"(id)
);

CREATE TABLE public.favorites (
                            id int NOT NULL,
                            nft_id int NOT NULL,
                            user_id int NOT NULL,
                            CONSTRAINT fav_pk PRIMARY KEY (id),
                            CONSTRAINT nft_id FOREIGN KEY (nft_id) REFERENCES public.nft(id),
                            CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES public."user"(id)
);

CREATE TABLE public."transaction" (
                                      id int NOT NULL,
                                      "timestamp" timestamp NOT NULL,
                                      nft_id int NOT NULL,
                                      user_id int NOT NULL,
                                      CONSTRAINT transaction_pk PRIMARY KEY (id),
                                      CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES public."user"(id),
                                      CONSTRAINT nft_id FOREIGN KEY (nft_id) REFERENCES public.nft(id)
);


