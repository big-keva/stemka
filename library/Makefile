LIB=../libstemka.a
OBJ=stemmers.o fuzzyrus.o fuzzyukr.o
ifdef _DEBUG
  CFLAGS += -ggdb
endif

all: $(LIB) $(OBJ)

clean:
	@rm -f $(OBJ)

clean_all: clean
	@rm -f $(LIB)

stemmers.o: stemmers.c ../include/stemmers.h Makefile
	@$(CC) $(CFLAGS) -c stemmers.c

fuzzyrus.o: fuzzyrus.c fuzzyrus.inc ../include/fuzzyrus.h
	@$(CC) $(CFLAGS) -c fuzzyrus.c

fuzzyukr.o: fuzzyukr.c fuzzyukr.inc ../include/fuzzyukr.h
	@$(CC) $(CFLAGS) -c fuzzyukr.c

$(LIB): $(OBJ)
	@echo Linking $(LIB)
	@ar -rc $(LIB) $(OBJ)
