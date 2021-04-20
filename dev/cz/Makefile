EXE=checkchz
OBJ=checkchz.o
CFLAGS += -I../stemka/
CC=g++

ifdef _DEBUG
  CFLAGS += -ggdb
endif

all: $(EXE) $(OBJ)

clean:
	@rm -f $(OBJ)

clean_all: clean
	@rm -f $(EXE)

checkchz.o: checkchz.cpp
	@$(CC) -c checkchz.cpp $(CFLAGS)

$(EXE): $(OBJ)
	@echo Linking $(EXE)
	@$(CC) -o $(EXE) $(OBJ) ../stemka/libstemka.a

